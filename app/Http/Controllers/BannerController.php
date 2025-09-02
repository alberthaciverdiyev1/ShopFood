<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BannerController extends Controller
{
    public function list()
    {
        return Banner::all();
    }

    public function add(Request $request)
    {

    }
}
