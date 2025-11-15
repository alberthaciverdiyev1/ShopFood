<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\BannerCategory;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {

//        $products = products();
//        $products = Product::all();
        $products = Product::limit(200)->get();
        $categories = BannerCategory::latest()->get();
        $tags = Tag::all();
        $locale = session('app-locale', 'en');

        $banners = Banner::query()
            ->where('is_active', 1)
            ->get()
            ->map(function($banner) use ($locale) {
                $banner->title = $banner->{'title_' . $locale} ?? $banner->title_en;
                $banner->subtitle = $banner->{'subtitle_' . $locale} ?? $banner->subtitle_en;
                return $banner;
            });

        $favoriteIds = auth()->user()
            ->favorites()
            ->pluck('product_id')
            ->toArray();
        return view('home', compact('products', 'banners','favoriteIds','categories','tags'));
    }


    public function welcome()
    {
        return view('welcome');
    }
}
