<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TagController extends Controller
{
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);

            $path = $request->file('image')->store('tags', 'public');

            $tag = Tag::create([
                'key' => $request->name,
                'image' => $path,
            ]);

            return redirect()
                ->route('tags.list')
                ->with('success', 'Tag created successfully!');

        } catch (\Exception $e) {
            Log::error('Tag creation error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function list(Request $request)
    {
        $tags = Tag::latest()->get();
        return view('admin.tags.index', compact('tags'));
    }

    public function update(Request $request, Tag $tag)
    {
        try {
            $request->validate([
                'name' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            ]);
            $data = [];
            if ($request->name !== null) {
                $data = ['key' => $request->name];
            }

            if ($request->hasFile('image')) {
                $path = $request->file('image')->store('tags', 'public');
                $data['image'] = $path;
            }
            if (($request->name !== null || $request->hasFile('image') === true) && !empty($data)) {

                $tag->update($data);
            }

            return redirect()
                ->route('tags.list')
                ->with('success', 'Tag updated successfully!');

        } catch (\Exception $e) {
            Log::error('Tag update error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(Tag $tag)
    {
        try {
            $tag->delete();

            return redirect()
                ->route('tags.list')
                ->with('success', 'Tag deleted successfully!');

        } catch (\Exception $e) {
            Log::error('Tag delete error: ' . $e->getMessage());
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
