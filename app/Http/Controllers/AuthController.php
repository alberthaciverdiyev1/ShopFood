<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    public function update(Request $request, int $id)
    {
//        $request->validate([
//            'name' => 'required|string|max:255',
//            'email' => 'required|email',
//            'discount_percentage' => 'nullable|integer|min:0|max:100',
//        ]);

        $validated = $request->validate([
            'reg_number' => 'sometimes|required|string|max:50',            // ИНН Регистрационный номер
            'tax_number' => 'sometimes|required|string|max:50',            // ДРН (VAT) Налоговый номер
            'password' => 'sometimes|required|string|max:20|min:6',                 // Телефон
            'email' => 'sometimes|required|email|max:255',                 // Email
            'street' => 'sometimes|required|string|max:255',              // Улица, дом
            'city' => 'sometimes|required|string|max:100',                // Город
            'country' => 'sometimes|required|string|max:100',             // Страна
            'zip' => 'sometimes|required|string|max:20',                  // Индекс
            'contact_name' => 'sometimes|required|string|max:255',        // Имя, Фамилия
            'contact_phone' => 'sometimes|required|string|max:20',        // Телефон
        ]);

        $user = auth()->user();
        $user->update($validated);

        return redirect()->route('profile')->with('success', 'User updated successfully!');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);
            $user = User::where('email', $credentials['email'])->where('is_active', '=', true)->first();
            if ($user && Auth::attempt($credentials)) {
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
                'password' => Hash::make(str()->random(10)), // Random password
                'email' => $validated['email'] ?? null,
                'street' => $validated['street'] ?? null,
                'city' => $validated['city'] ?? null,
                'country' => $validated['country'] ?? null,
                'zip' => $validated['zip'] ?? null,
                'contact_name' => $validated['contact_name'] ?? null,
                'contact_phone' => $validated['contact_phone'] ?? null,
                'is_active' => false,
            ]);

            return redirect()
                ->route('web:register')
                ->with('success', 'Yeni istifadeci uğurla qeydiyyatdan keçdi!');
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
        $user = auth()->user();
        return view('auth.profile', compact('user'));
    }

}
