<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ProductsController extends Controller
{
    public function index()
    {
        $products = products(); // helper funksiyası
        return view('admin.dashboard.products', compact('products'));
    }
}
