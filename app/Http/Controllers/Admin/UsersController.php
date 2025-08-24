<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Mail\UserActivationMail;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    public function index() {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    public function toggle(User $user) {
        // Əgər artıq aktivdirsə → deaktiv et
        if ($user->is_active == 1) {
            $user->update(['is_active' => 0]);
        } 
        // Əgər passivdirsə və is_send_email=0 → email göndər və aktiv et
        elseif ($user->is_active == 0 && $user->is_send_email == 0) {
            $activationLink = url('/activate/'.$user->id);

            Mail::to($user->email)->send(new UserActivationMail($activationLink));

            $user->update([
                'is_active' => 1,
                'is_send_email' => 1
            ]);
        }

        return back()->with('success', 'Əməliyyat uğurla icra olundu');
    }
}
