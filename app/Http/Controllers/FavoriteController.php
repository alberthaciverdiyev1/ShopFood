<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    /**
     * List user favorites with API product data
     */
    public function list()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $apiProducts = products();

        $favoritesWithData = $favorites->map(function ($fav) use ($apiProducts) {
            $productData = collect($apiProducts)->firstWhere('code', $fav->product_id);
            return [
                'product_id' => $fav->product_id,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });
        $data = $favoritesWithData->toArray();
        return view('favorites',
            ['favorites' => $data,
            "products" => $apiProducts]);
    }
    /**
     * List user favorites with API product data
     */
    public function listAjax()
    {
        $user = Auth::user();

        $favorites = $user->favorites()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $apiProducts = products();

        $favoritesWithData = $favorites->map(function ($fav) use ($apiProducts) {
            $productData = collect($apiProducts)->firstWhere('id', $fav->product_id);
            return [
                'product_id' => $fav->product_id,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });
        $data = $favoritesWithData->toArray();
        return response()->json($data);
    }

    /**
     * Add product to favorites
     */
    public function add(string $productId): JsonResponse
    {
        $user = Auth::user();

        $apiProducts = products();
        $productData = collect($apiProducts)->firstWhere('code', $productId);

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
