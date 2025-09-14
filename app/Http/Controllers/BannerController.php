<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function list()
    {
        $banners = Banner::latest()->get();
        return view('admin.banner.index', compact('banners'));
    }

    public function add(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'title_cz' => 'nullable|string|max:255',
            'subtitle_cz' => 'nullable|string|max:255',
            'url' => 'nullable|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $path = $request->file('image')->store('banners', 'public');

        $banner = Banner::create([
            'title_en' => $validated['title_en'] ?? null,
            'subtitle_en' => $validated['subtitle_en'] ?? null,
            'title_cz' => $validated['title_cz'] ?? null,
            'subtitle_cz' => $validated['subtitle_cz'] ?? null,
            'url' => $validated['url'] ?? null,
            'image' => $path,
            'is_active' => true,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner added successfully');
    }

    public function edit(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validate([
            'title_en' => 'nullable|string|max:255',
            'subtitle_en' => 'nullable|string|max:255',
            'title_cz' => 'nullable|string|max:255',
            'subtitle_cz' => 'nullable|string|max:255',
            'url' => 'nullable|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $path = $request->file('image')->store('banners', 'public');
            $validated['image'] = $path;
        }

        $banner->update($validated);

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully');
    }

    // Banner sil
    public function delete($id)
    {
        $banner = Banner::findOrFail($id);

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json(['message' => 'Banner deleted successfully']);
    }
}
