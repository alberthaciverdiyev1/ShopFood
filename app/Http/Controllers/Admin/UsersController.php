<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\ResetPasswordMail;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserActivationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class UsersController extends Controller
{
    // List all users
    public function index()
    {
        $users = User::all();
        return view('admin.dashboard.users', compact('users'));
    }

    public function show(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.show', compact('user'));
    }

    public function edit(int $id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));
    }


    public function update(Request $request, User $user)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:50',
            'contact_phone' => 'nullable|string|max:50',
            'reg_number' => 'nullable|string|max:100',
            'tax_number' => 'nullable|string|max:100',
            'street' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'zip' => 'nullable|string|max:20',
            'order_type' => 'required',
            'discount_percent' => 'nullable|integer|min:0|max:100',
            'is_active' => 'nullable|boolean',
            'is_admin' => 'nullable|boolean',
        ]);

        $user->update([
            'contact_name' => $request->contact_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'contact_phone' => $request->contact_phone,
            'reg_number' => $request->reg_number,
            'tax_number' => $request->tax_number,
            'street' => $request->street,
            'city' => $request->city,
            'country' => $request->country,
            'zip' => $request->zip,
            'order_type' => $request->order_type,
            'discount_percent' => $request->discount_percent ?? 0,
            'is_active' => $request->has('is_active'),
            'is_admin' => $request->has('is_admin'),
        ]);

        return redirect()->route('admin.users.edit', $user->id)
            ->with('success', 'User updated successfully!');
    }

    // Forgot password → send reset link
    public function forgotPassword(int $id)
    {
        $user = User::findOrFail($id);
        $token = Password::createToken($user);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));

        return response()->json([
            'success' => true,
            'message' => 'Password reset link has been sent!'
        ]);
    }

    public function showResetForm(Request $request, $token)
    {
        $email = $request->query('email');
        $hideNavbar = true;
        return view('auth.reset_password', compact('token', 'email', 'hideNavbar'));
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->is_send_email = 0;
                $user->is_active = 1;
                $user->save();
            }
        );
        return $status == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password has been reset!')
                : back()->withErrors(['email' => [__($status)]]);
    }

    // Delete user
    public function delete(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function confirmUser(int $id)
    {
        $user = User::findOrFail($id);
        $token = Password::createToken($user);
        Mail::to($user->email)->send(new ResetPasswordMail($user, $token));
        $user->is_send_email = 1;
        $user->save();
        return redirect()->route('admin.users');
    }

}
