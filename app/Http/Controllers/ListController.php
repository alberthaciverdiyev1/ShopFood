<?php

namespace App\Http\Controllers;

use App\Models\BannerCategory;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ListController extends Controller
{

    public function list(Request $request)
    {
        $params = $request->all();
        $bannerCategories = BannerCategory::latest()->get();

        $categories = Category::whereNull('parent_id')->with('children')->latest()->get();

        $news = $request->input('news');
        $bannerCategoryInput = $request->input('banner_category');
        $categoryInput = $request->input('category');
        $subCategoryInput = $request->input('sub-category');


        $query = Product::query();

        if ($bannerCategoryInput) {
            $cats = (array) $bannerCategoryInput;

            $query->where(function($q) use ($cats) {
                foreach ($cats as $cat) {
                    $q->orWhereRaw(
                        "EXISTS (
                        SELECT 1
                        FROM jsonb_array_elements_text((tags::jsonb)) AS elem(value)
                        WHERE lower(trim(elem.value)) = lower(trim(?))
                    )",
                        [$cat]
                    );
                }
            });
        }
        if ($categoryInput) {
            $query->where('category', $categoryInput);
        }
        if ($subCategoryInput) {
            $query->where('subcategory', $subCategoryInput);
        }

        if ($news !== null) {
            $query->orderBy('created_at', 'desc');
        }

        $products = $query->paginate(50)->withQueryString();
        return view('list', [
            'products' => $products,
            'filters' => $params,
            'banner_categories' => $bannerCategories,
            'categories' => $categories,
        ]);
    }


}
