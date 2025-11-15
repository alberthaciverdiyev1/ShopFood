<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BannerCategory;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BannerCategoryController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'key' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $path = $request->file('image')->store('categories', 'public');

            $tag = BannerCategory::create([
                'name' => $request->name,
                'key' => $request->key,
                'image' => $path,
            ]);

            return redirect()
                ->route('bannerCategory.list')
                ->with('success', 'Banner Category created successfully!');

        } catch (\Exception $e) {
            Log::error('Banner Category creation error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function getAll(Request $request)
    {
        $categories = BannerCategory::latest()->get();
        return view('admin.bannerCategories.index', compact('categories'));
    }

    public function update(Request $request, BannerCategory $category)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'key' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            $data = [];
            if ($request->name !== null) {
                $data = ['name' => $request->name];
            }
            if ($request->key !== null) {
                $data = ['key' => $request->key];
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('tags', 'public');
                $data['image'] = $path;
            }
            if (($request->key !== null || $request->name !== null || $request->hasFile('image') === true) && !empty($data)) {

                $category->update($data);
            }

            return redirect()
                ->route('bannerCategory.list')
                ->with('success', 'Banner Category updated successfully!');

        } catch (\Exception $e) {
            Log::error('Banner Category update error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(BannerCategory $category)
    {
        try {
            $category->delete();

            return redirect()
                ->route('bannerCategory.list')
                ->with('success', 'Banner Category deleted successfully!');

        } catch (\Exception $e) {
            Log::error('BannerCategory delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
