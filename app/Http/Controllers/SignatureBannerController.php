<?php

namespace App\Http\Controllers;

use App\Models\Signaturebanner;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SignatureBannerController extends Controller
{
    /** Folder inside /public and fixed file name of the banner. */
    public const DIR  = 'signaturebanner';
    public const FILE = 'banner.jpg';

    /**
     * Show the single signature banner image.
     */
    public function index()
    {
        $banner = Signaturebanner::latest('updated_at')->first();

        return view('pages.signature-banner', compact('banner'));
    }

    /**
     * Save banner details. The image is always stored as
     * public/signaturebanner/banner.jpg (URL: /signaturebanner/banner.jpg).
     * Any existing banner.jpg is deleted first, then the new one is written.
     */
    public function store(Request $request)
    {
        $banner = Signaturebanner::latest('updated_at')->first() ?? new Signaturebanner();

        // Image is only required when there is no banner image yet.
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'state'       => ['nullable', 'string', 'max:255'],
            'category'    => ['nullable', 'string', 'max:255'],
            'expiry_date' => ['nullable', 'date'],
            'banner_file' => [$banner->file_path ? 'nullable' : 'required', 'image', 'mimes:png,jpg,jpeg,gif,webp', 'max:2048'],
        ]);

        $filePath = $banner->file_path;

        if ($request->hasFile('banner_file')) {
            $oldPath  = $banner->file_path;
            $filePath = $this->saveAsBannerJpg($request->file('banner_file'));

            // Remove an old image from the previous storage location (storage/app/public/banners/...).
            if ($oldPath && $oldPath !== $filePath) {
                Storage::disk('public')->delete($oldPath);
            }
        }

        $banner->fill([
            'added_by'    => $banner->added_by ?? Auth::id(),
            'name'        => $data['name'],
            'state'       => $data['state'] ?? null,
            'category'    => $data['category'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'publish'     => $request->boolean('publish'),
            'file_path'   => $filePath,
        ]);

        // Always bump updated_at so the ?v= cache-buster changes after a re-upload.
        $banner->updated_at = now();
        $banner->save();

        return redirect()->route('banner.index')->with('success', 'Banner saved successfully.');
    }

    /**
     * Delete the existing public/signaturebanner/banner.jpg and write the
     * uploaded image in its place, converted to JPG when GD is available.
     */
    private function saveAsBannerJpg(UploadedFile $file): string
    {
        $dir    = public_path(self::DIR);
        $target = $dir . DIRECTORY_SEPARATOR . self::FILE;

        File::ensureDirectoryExists($dir, 0755);

        // 1. Delete the old banner.jpg first.
        if (File::exists($target)) {
            File::delete($target);
        }

        // 2. Save the new image as banner.jpg.
        if (! $this->convertToJpg($file->getRealPath(), $target)) {
            // No GD / unsupported format: store the file as-is under the fixed name.
            $file->move($dir, self::FILE);
        }

        return self::DIR . '/' . self::FILE;
    }

    private function convertToJpg(string $source, string $target): bool
    {
        if (! function_exists('imagecreatefromstring') || ! function_exists('imagejpeg')) {
            return false;
        }

        $src = @imagecreatefromstring((string) file_get_contents($source));
        if (! $src) {
            return false;
        }

        // Flatten transparency (PNG/WebP/GIF) onto a white background.
        $w   = imagesx($src);
        $h   = imagesy($src);
        $jpg = imagecreatetruecolor($w, $h);
        imagefill($jpg, 0, 0, imagecolorallocate($jpg, 255, 255, 255));
        imagecopy($jpg, $src, 0, 0, 0, 0, $w, $h);

        return imagejpeg($jpg, $target, 90);
    }
}
