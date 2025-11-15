<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function create()
    {
        $categories = Category::where('parent_id', null)->get();
        return view('admin.categories.create', compact('categories'));
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'key' => 'required|string|max:255|unique:categories,key',
                'parent_id' => 'nullable|integer|exists:categories,id',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $path = null;
            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('categories', 'public');
            }

            Category::create([
                'name' => $request->name,
                'key' => $request->key,
                'parent_id' => $request->parent_id,
                'image' => $path,
            ]);

            return redirect()
                ->route('category.list')
                ->with('success', $request->parent_id ? 'Subcategory created successfully!' : 'Category created successfully!');

        } catch (\Exception $e) {
            Log::error('Category creation error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }


    public function getAll()
    {
        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->latest()
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function edit(Category $category)
    {
        // Sadece ana kategorileri (kendisi hariç) çekiyoruz, böylece parent olarak seçilebilir
        $categories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->with('children')
            ->latest()
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }


    public function update(Request $request, Category $category)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'key' => 'nullable|string|max:255|unique:categories,key,' . $category->id,
                'parent_id' => 'nullable|integer|exists:categories,id|not_in:' . $category->id,
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $data = $request->only(['name', 'key', 'parent_id']);

            if ($request->hasFile('image')) {
                if ($category->image && Storage::disk('public')->exists($category->image)) {
                    Storage::disk('public')->delete($category->image);
                }

                $data['image'] = $request->file('image')->store('categories', 'public');
            }

            $category->update(array_filter($data));

            return redirect()
                ->route('category.list')
                ->with('success', $category->parent_id ? 'Subcategory updated successfully!' : 'Category updated successfully!');

        } catch (\Exception $e) {
            Log::error('Category update error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Category $category)
    {
        try {
            if ($category->children()->count() > 0) {
                foreach ($category->children as $child) {
                    $child->delete();
                }
            }

            if ($category->image && Storage::disk('public')->exists($category->image)) {
                Storage::disk('public')->delete($category->image);
            }

            $category->delete();

            return redirect()
                ->route('category.list')
                ->with('success', 'Category and its subcategories deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Category delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
