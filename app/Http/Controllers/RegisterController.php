<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showForm() {
        return view('admin.register');
    }

    public function store(Request $request) {
        $request->validate([
            'email' => 'required|email|unique:users,email',
        ]);

        User::create([
            'email' => $request->email,
            'is_active' => 0,
        ]);

        return back()->with('success', 'Sorğu göndərildi.');
    }
}
