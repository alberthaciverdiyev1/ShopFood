<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();

                return redirect()->intended('/');
            }

            return back()->withErrors([
                'email' => 'Email və ya şifrə yanlışdır.',
            ])->withInput();
        }

        return view('login');
    }

    public function register(Request $request)
    {
        if ($request->isMethod('post')) {

            $validated = $request->validate([
                'full_name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6',
                'register_number' => 'required|string|max:50',
                'vat_number' => 'required|string|max:50',
                'phone' => 'required|string|max:20',
                'street' => 'required|string|max:255',
                'city' => 'required|string|max:100',
                'address' => 'required|string|max:255',
            ]);

            $user = User::create([
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'register_number' => $validated['register_number'],
                'vat_number' => $validated['vat_number'],
                'phone' => $validated['phone'],
                'street' => $validated['street'],
                'city' => $validated['city'],
                'address' => $validated['address'],
            ]);

            auth()->login($user);

            return redirect('/')->with('success', 'Hesabınız yaradıldı!');
        }

        return view('register');
    }
}
