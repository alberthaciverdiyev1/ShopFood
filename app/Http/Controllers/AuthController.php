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

            // Validation
            $validated = $request->validate([
                'reg_number' => 'required|string|max:50',            // ИНН Регистрационный номер
                'tax_number' => 'required|string|max:50',            // ДРН (VAT) Налоговый номер
                'password' => 'required|string|max:20|min:6',                 // Телефон
                'phone' => 'required|string|max:20',                 // Телефон
                'email' => 'required|email|max:255',                 // Email
                'street' => 'required|string|max:255',              // Улица, дом
                'city' => 'required|string|max:100',                // Город
                'country' => 'required|string|max:100',             // Страна
                'zip' => 'required|string|max:20',                  // Индекс
                'contact_name' => 'required|string|max:255',        // Имя, Фамилия
                'contact_phone' => 'required|string|max:20',        // Телефон
            ]);

            $user = User::create([
                'reg_number' => $validated['reg_number'],
                'tax_number' => $validated['tax_number'],
                'phone' => $validated['phone'],
                'password' => Hash::make($validated['password']),
                'email' => $validated['email'] ?? null,
                'street' => $validated['street'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'zip' => $validated['zip'] ?? null,
                'contact_name' => $validated['contact_name'] ?? null,
                'contact_phone' => $validated['contact_phone'] ?? null,
            ]);
            auth()->login($user);
            return redirect('/')->with('success', 'Şirkət uğurla qeydiyyatdan keçdi!');
        }

        return view('register');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();

        $request->session()->regenerateToken();
        return redirect('/welcome');
    }
    public function profile()
{
    $user = auth()->user(); // login olmuş user
    return view('auth.profile', compact('user'));
}

}
