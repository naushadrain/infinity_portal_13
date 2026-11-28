<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

/**
 * Developer log viewer: reads storage/logs/*.log, parses Laravel log
 * entries into a readable structure and supports live tailing (polling
 * by byte offset). Admin only (role_id 1).
 */
class LogViewerController extends Controller
{
    /** Bytes read from the end of the file on first load. */
    private const INITIAL_BYTES = 1_048_576; // 1 MB

    /** Max bytes returned in one poll (protects against huge bursts). */
    private const POLL_MAX_BYTES = 524_288; // 512 KB

    private const MAX_ENTRIES = 300;

    private const HEADER = '/^\[(\d{4}-\d{2}-\d{2}[ T]\d{2}:\d{2}:\d{2}(?:\.\d+)?(?:[+\-]\d{2}:?\d{2})?)\]\s+([\w\-]+)\.([A-Z]+):\s?(.*)$/';

    public function index()
    {
        $this->authorizeAdmin();

        $files = $this->logFiles();

        return view('pages.laravel-logs', [
            'files'    => $files,
            'logLevel' => config('logging.channels.' . config('logging.default') . '.level')
                ?? env('LOG_LEVEL', 'debug'),
        ]);
    }

    /**
     * JSON entries. Without `offset`: the latest entries (tail of file).
     * With `offset`: only entries appended after that byte offset.
     */
    public function entries(Request $request): JsonResponse
    {
        $this->authorizeAdmin();

        $path = $this->resolveFile($request->query('file'));
        if (! $path) {
            return response()->json(['entries' => [], 'offset' => 0, 'size' => 0, 'file' => null]);
        }

        clearstatcache(true, $path);
        $size   = filesize($path);
        $offset = $request->has('offset') ? (int) $request->query('offset') : null;
        $reset  = false;

        if ($offset === null) {
            $start = max(0, $size - self::INITIAL_BYTES);
        } elseif ($offset > $size) {
            // File was cleared or rotated: start again from the top.
            $start = 0;
            $reset = true;
        } else {
            $start = $offset;
        }

        $length = $size - $start;
        if ($offset !== null && $length > self::POLL_MAX_BYTES) {
            $start  = $size - self::POLL_MAX_BYTES;
            $length = self::POLL_MAX_BYTES;
        }

        $chunk = '';
        if ($length > 0) {
            $fh = fopen($path, 'rb');
            fseek($fh, $start);
            $chunk = fread($fh, $length);
            fclose($fh);

            // When we started mid-file, drop the partial first entry.
            if ($start > 0 && ($offset === null || $reset === false && $start !== $offset)) {
                $pos   = preg_match('/^\[\d{4}-\d{2}-\d{2}/m', $chunk, $m, PREG_OFFSET_CAPTURE) ? $m[0][1] : strlen($chunk);
                $chunk = substr($chunk, $pos);
            }
        }

        $entries = $this->parse($chunk);
        $entries = array_slice($entries, -self::MAX_ENTRIES);

        return response()->json([
            'file'      => basename($path),
            'size'      => $size,
            'sizeHuman' => $this->humanSize($size),
            'offset'    => $size,
            'reset'     => $reset,
            'truncated' => $offset === null && $start > 0,
            'entries'   => array_reverse($entries), // newest first
        ]);
    }

    public function download(Request $request)
    {
        $this->authorizeAdmin();

        $path = $this->resolveFile($request->query('file'));
        abort_unless($path, 404);

        return response()->download($path);
    }

    public function clear(Request $request)
    {
        $this->authorizeAdmin();

        $path = $this->resolveFile($request->input('file'));
        abort_unless($path, 404);

        file_put_contents($path, '');

        return redirect()->route('logs.index', ['file' => basename($path)])
            ->with('success', basename($path) . ' cleared.');
    }

    /* ------------------------------------------------------------------ */

    private function authorizeAdmin(): void
    {
        abort_unless((int) Auth::user()?->role_id === 1, 403, 'Only administrators can view the application logs.');
    }

    /** @return array<int, array{name:string,size:string,modified:string}> */
    private function logFiles(): array
    {
        $files = File::glob(storage_path('logs/*.log')) ?: [];
        usort($files, fn ($a, $b) => filemtime($b) <=> filemtime($a));

        return array_map(fn ($f) => [
            'name'     => basename($f),
            'size'     => $this->humanSize(filesize($f)),
            'modified' => date('d M Y H:i', filemtime($f)),
        ], $files);
    }

    /** Only allow plain *.log names inside storage/logs. */
    private function resolveFile(?string $name): ?string
    {
        if ($name === null || $name === '') {
            $files = $this->logFiles();
            $name  = $files[0]['name'] ?? null;
            if (! $name) {
                return null;
            }
        }

        $name = basename($name);
        if (! preg_match('/^[\w\-.]+\.log$/', $name)) {
            return null;
        }

        $path = storage_path('logs/' . $name);

        return is_file($path) ? $path : null;
    }

    /** Split raw log text into structured entries. */
    private function parse(string $raw): array
    {
        if (trim($raw) === '') {
            return [];
        }

        $entries = [];
        $current = null;

        foreach (preg_split('/\R/', $raw) as $line) {
            if (preg_match(self::HEADER, $line, $m)) {
                if ($current) {
                    $entries[] = $this->finish($current);
                }
                $current = ['time' => $m[1], 'env' => $m[2], 'level' => strtolower($m[3]), 'head' => $m[4], 'body' => []];
            } elseif ($current) {
                $current['body'][] = $line;
            }
        }

        if ($current) {
            $entries[] = $this->finish($current);
        }

        return $entries;
    }

    private function finish(array $e): array
    {
        $head = $e['head'];
        $body = $e['body'];

        $exception = null;
        $location  = null;
        $context   = null;

        // Laravel puts {"exception":"[object] (Class(code: 0): message at /path/file.php:123)"} after the message.
        if (preg_match('/\{"exception":"\[object\] \(([\w\\\\]+)\(code: [^)]*\): /', $head, $m, PREG_OFFSET_CAPTURE)) {
            $exception = stripslashes($m[1][0]);
            $head      = rtrim(substr($head, 0, $m[0][1]));
        } elseif (preg_match('/\s(\{.*\}|\[.*\])\s*$/', $head, $m, PREG_OFFSET_CAPTURE)) {
            // Plain context array, e.g. Log::error('x', ['id' => 1])
            $decoded = json_decode($m[1][0], true);
            if (is_array($decoded)) {
                $context = $decoded;
                $head    = rtrim(substr($head, 0, $m[1][1]));
            }
        }

        $full = $e['head'] . "\n" . implode("\n", $body);
        if (preg_match('/ at (.+?\.php):(\d+)\)/', $full, $m)) {
            $location = ['file' => $this->shortPath($m[1]), 'line' => (int) $m[2]];
        }

        // Stack frames.
        $frames = [];
        foreach ($body as $line) {
            if (preg_match('/^#(\d+)\s+(.*)$/', $line, $m)) {
                $text = $m[2];
                $file = null;
                $ln   = null;
                if (preg_match('/^(.+?)\((\d+)\):\s*(.*)$/', $text, $fm)) {
                    $file = $this->shortPath($fm[1]);
                    $ln   = (int) $fm[2];
                    $text = $fm[3];
                }
                $frames[] = [
                    'n'      => (int) $m[1],
                    'file'   => $file,
                    'line'   => $ln,
                    'call'   => $this->shortPath($text),
                    'vendor' => $file === null || str_starts_with($file, 'vendor/'),
                ];
            }
        }

        // Anything else in the body that is not a stack frame (e.g. multi-line messages).
        $extra = collect($body)
            ->reject(fn ($l) => preg_match('/^#\d+\s|^\[stacktrace\]$|^"\}?\s*$|^\[previous exception\]/', $l) || trim($l) === '')
            ->implode("\n");

        return [
            'time'      => str_replace('T', ' ', substr($e['time'], 0, 19)),
            'env'       => $e['env'],
            'level'     => $e['level'],
            'message'   => $this->shortPath($head),
            'exception' => $exception,
            'location'  => $location,
            'context'   => $context,
            'extra'     => mb_substr($this->shortPath($extra), 0, 4000),
            'frames'    => array_slice($frames, 0, 60),
            'raw'       => mb_substr($e['head'] . (count($body) ? "\n" . implode("\n", $body) : ''), 0, 20000),
        ];
    }

    private function shortPath(string $text): string
    {
        $base = str_replace('\\', '/', base_path()) . '/';

        return str_replace([$base, str_replace('/', '\\', $base), str_replace('/', '\\\\', $base)], '', str_replace('\\\\', '\\', $text));
    }

    private function humanSize(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i     = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }

        return round($bytes, $i ? 1 : 0) . ' ' . $units[$i];
    }
}
