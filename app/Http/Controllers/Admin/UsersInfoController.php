<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UsersInfoController extends Controller
{
     public function index() {
        $users = User::all();
        return view('admin.dashboard.users', compact('users'));
    }
}
