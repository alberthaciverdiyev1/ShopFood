<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UserController extends Controller
{

    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
        ]);

        $user->update($request->only(['name', 'email', 'discount_percentage']));

        return redirect()->route('admin.users.index')
            ->with('success', 'User updated successfully!');
    }


    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    public function login()
    {
        return view('pages.auth.login');
    }

    public function register()
    {
        return view('welcome');
    }

}
