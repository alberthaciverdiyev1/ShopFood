<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $products = products();

        $banners = Banner::query()->where('is_active', 1)->get();

        return view('home', compact('products', 'banners'));
    }

    public function welcome()
    {
        return view('welcome');
    }
}
