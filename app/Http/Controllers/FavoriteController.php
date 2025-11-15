<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;

class FavoriteController extends Controller
{
    /**
     * List user favorites for Blade view
     */
    public function list()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->orderBy('created_at', 'desc')
            ->get();

        $favoritesWithData = $favorites->map(function ($fav) {
            $productData = Product::where('code', $fav->product_id)->first();

            return [
                'product_id' => $fav->product_id,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });

        return view('favorites', [
            'favorites' => $favoritesWithData,
            'products'  => Product::limit(20)->get(),
        ]);
    }

    /**
     * List user favorites via AJAX
     */
    public function listAjax()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->orderBy('created_at', 'desc')
            ->get();

        $favoritesWithData = $favorites->map(function ($fav) {
            $productData = Product::where('code', $fav->product_id)->first();

            return [
                'product_id' => $fav->product_id,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });

        return response()->json($favoritesWithData);
    }

    /**
     * Add product to favorites
     */
    public function add(string $productId): JsonResponse
    {
        $user = Auth::user();

        $productData = Product::where('code', $productId)->first();

        if (!$productData) {
            return response()->json([
                'success' => 404,
                'message' => __('Product not found.'),
            ], 404);
        }

        $user->favorites()->updateOrCreate(
            ['product_id' => $productId],
            ['user_id' => $user->id]
        );

        return response()->json([
            'success' => 200,
            'message' => __('Product added to favorites.'),
            'data' => $productData,
        ]);
    }

    /**
     * Remove product from favorites
     */
    public function delete(string $productId): JsonResponse
    {
        $user = Auth::user();

        $favorite = $user->favorites()->where('product_id', $productId)->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => 200,
                'message' => __('Product removed from favorites.'),
            ]);
        }

        return response()->json([
            'success' => 200,
            'message' => __('Product was not in favorites.'),
        ]);
    }
}
