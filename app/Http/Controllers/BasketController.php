<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BasketController extends Controller
{
    public function basket(){
        $products = products();

        return view('basket',compact('products'));
    }
}
