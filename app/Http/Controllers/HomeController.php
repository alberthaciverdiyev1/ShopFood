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
       // dd(Product::all()->count());

        $products = Product::take(100)->get()->filter(function($product) {
            return collect($product->warehouses)
                ->contains(fn($w) => ($w['warehouse_code'] ?? '') === 'NOVY_SKLAD');
        });
//        $products = Product::take(100)->get();
       // $products = Product::limit(200)->where('code','KZZ13019')->get();
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
