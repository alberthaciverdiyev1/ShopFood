<?php
namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'required|string',
        ]);

        $tag = Tag::create([
            'key' => $request->key,
            'value' => $request->value,
        ]);

        return response()->json($tag, 201);
    }
    public function list(Request $request)
    {

        $tag = Tag::all();

        return response()->json($tag, 201);
    }
}

