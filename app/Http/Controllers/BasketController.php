<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BasketController extends Controller
{
    public function basket(){
        $response = Http::withoutVerifying()->get('https://fakestoreapi.com/products');
        $products = $response->json();
            
        return view('basket',compact('products'));
    }
}
