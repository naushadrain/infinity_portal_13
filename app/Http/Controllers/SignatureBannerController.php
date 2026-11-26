<?php

namespace App\Http\Controllers;

use App\Models\Signaturebanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SignatureBannerController extends Controller
{
    /**
     * Show the single signature banner image.
     */
    public function index()
    {
        $banner = Signaturebanner::latest('updated_at')->first();

        return view('pages.signature-banner', compact('banner'));
    }

    /**
     * Serve a banner image straight from storage. This works on shared
     * hosting (cPanel) where the public/storage symlink is missing or
     * blocked, so images don't depend on `php artisan storage:link`.
     */
    public function image(string $filename)
    {
        $path = 'banners/' . basename($filename);

        /** @var \Illuminate\Filesystem\FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        abort_unless($disk->exists($path), 404);

        return $disk->response($path, null, [
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }

    /**
     * Upload the banner image. Only one banner exists: a new upload
     * replaces the current image and deletes the old file.
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

        $oldPath = $banner->file_path;
        $newPath = $request->hasFile('banner_file')
            ? $request->file('banner_file')->store('banners', 'public')
            : $oldPath;

        $banner->fill([
            'added_by'    => $banner->added_by ?? Auth::id(),
            'name'        => $data['name'],
            'state'       => $data['state'] ?? null,
            'category'    => $data['category'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'publish'     => $request->boolean('publish'),
            'file_path'   => $newPath,
        ])->save();

        if ($oldPath && $oldPath !== $newPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return redirect()->route('banner.index')->with('success', 'Banner saved successfully.');
    }
}
