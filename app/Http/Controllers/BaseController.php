<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class BaseController extends Controller
{
    public function changeLocale(Request $request)
    {
        $request->validate([
            'locale' => ['required', 'in:az,ru,en'],
        ]);

        session(['app-locale' => $request->input('locale')]);

        return back();
    }

}
