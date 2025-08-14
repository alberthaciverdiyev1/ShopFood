<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        // $response = Http::get('https://api.escuelajs.co/api/v1/products');
        $response = Http::withoutVerifying()->get('https://fakestoreapi.com/products');

        $products = $response->json();

        return view('home', compact('products'));
    }
}
