<?php

namespace App\Http\Controllers;

use App\Models\Signaturebanner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SignatureBannerController extends Controller
{
    public function index()
    {
        $banners = Signaturebanner::latest()->paginate(15);

        return view('pages.signature-banner', compact('banners'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'state'       => ['nullable', 'string', 'max:100'],
            'category'    => ['nullable', 'string', 'max:100'],
            'details'     => ['nullable', 'string'],
            'expiry_date' => ['nullable', 'date'],
            'banner_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,webp', 'max:2048'],
        ]);

        $filePath = null;
        if ($request->hasFile('banner_file')) {
            $filePath = $request->file('banner_file')->store('banners', 'public');
        }

        Signaturebanner::create([
            'added_by'    => Auth::id(),
            'name'        => $data['name'],
            'state'       => $data['state'] ?? null,
            'category'    => $data['category'] ?? null,
            'details'     => $data['details'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'publish'     => $request->boolean('publish'),
            'file_path'   => $filePath,
        ]);

        return redirect()->route('banner.index')->with('success', 'Banner created successfully.');
    }

    public function update(Request $request, string $id)
    {
        $banner = Signaturebanner::findOrFail($id);

        $data = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'state'       => ['nullable', 'string', 'max:100'],
            'category'    => ['nullable', 'string', 'max:100'],
            'details'     => ['nullable', 'string'],
            'expiry_date' => ['nullable', 'date'],
            'banner_file' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif,webp', 'max:2048'],
        ]);

        $filePath = $banner->file_path;
        if ($request->hasFile('banner_file')) {
            if ($filePath) {
                Storage::disk('public')->delete($filePath);
            }
            $filePath = $request->file('banner_file')->store('banners', 'public');
        }

        $banner->update([
            'name'        => $data['name'],
            'state'       => $data['state'] ?? null,
            'category'    => $data['category'] ?? null,
            'details'     => $data['details'] ?? null,
            'expiry_date' => $data['expiry_date'] ?? null,
            'publish'     => $request->boolean('publish'),
            'file_path'   => $filePath,
        ]);

        return redirect()->route('banner.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(string $id)
    {
        $banner = Signaturebanner::findOrFail($id);

        if ($banner->file_path) {
            Storage::disk('public')->delete($banner->file_path);
        }

        $banner->delete();

        return redirect()->route('banner.index')->with('success', 'Banner deleted successfully.');
    }
}
