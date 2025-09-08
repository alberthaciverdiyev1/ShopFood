<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BasketController extends Controller
{
//    public function basket()
//    {
//        $products = products();
//
//        return view('basket', compact('products'));
//    }

    public function basket()
    {
        $user = Auth::user();

        $basket = $user->basket()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $apiProducts = products();

        $basketWithData = $basket->map(function ($fav) use ($apiProducts) {
            $productData = collect($apiProducts)->firstWhere('id', $fav->product_id);
            return [
                'product_id' => $fav->product_id,
                'quantity' => $fav->quantity,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });
        $data = $basketWithData->toArray();
        return view('basket',
            ['basket' => $data, "products" => $apiProducts]);
    }

    /**
     * List user basket with API product data
     */
    public function listAjax()
    {
        $user = Auth::user();

        $basket = $user->basket()
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $apiProducts = products();

        $basketWithData = $basket->map(function ($fav) use ($apiProducts) {
            $productData = collect($apiProducts)->firstWhere('id', $fav->product_id);
            return [
                'product_id' => $fav->product_id,
                'product' => $productData,
                'added_at' => $fav->created_at,
            ];
        });
        $data = $basketWithData->toArray();
        return response()->json($data);
    }

    /**
     * Add product to basket
     */
    public function add(int $productId): JsonResponse
    {
        $user = Auth::user();

        $apiProducts = products();
        $productData = collect($apiProducts)->firstWhere('id', $productId);

        if (!$productData) {
            return response()->json([
                'success' => 404,
                'message' => __('Product not found.'),
            ], 404);
        }

        $user->basket()->updateOrCreate(
            ['product_id' => $productId],
            ['user_id' => $user->id]
        );

        return response()->json([
            'success' => 200,
            'message' => __('Product added to basket.'),
            'data' => $productData,
        ]);
    }

    public function updateQuantity(int $productId, Request $request): JsonResponse
    {
        $user = Auth::user();
        $increment = $request->input('increment', 1);

        $basketItem = $user->basket()->where('product_id', $productId)->first();

        if (!$basketItem) {
            return response()->json([
                'success' => 404,
                'message' => __('Basket item not found.'),
            ], 404);
        }

        $newQuantity = $basketItem->quantity + $increment;

        if ($newQuantity > 0) {
            $basketItem->update(['quantity' => $newQuantity]);
        } else {
            // quantity 0 olduqda sil
            $basketItem->delete();
            return response()->json([
                'success' => 200,
                'message' => __('Product removed from basket.'),
                'deleted' => true,
            ]);
        }

        $apiProducts = products();
        $productData = collect($apiProducts)->firstWhere('id', $basketItem->product_id);

        return response()->json([
            'success' => 200,
            'message' => __('Product quantity updated in basket.'),
            'data' => $productData,
            'quantity' => $basketItem->quantity
        ]);
    }

    /**
     * Remove product from basket
     */
    public function delete(int $productId): JsonResponse
    {
        $user = Auth::user();

        $favorite = $user->basket()->where('product_id', $productId)->first();

        if ($favorite) {
            $favorite->delete();

            return response()->json([
                'success' => 200,
                'message' => __('Product removed from basket.'),
            ]);
        }

        return response()->json([
            'success' => 200,
            'message' => __('Product was not in basket.'),
        ]);
    }
}
