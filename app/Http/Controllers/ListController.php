<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{
     public function list()
    {
        $products = products();

        return view('list', compact('products'));
    }
}
