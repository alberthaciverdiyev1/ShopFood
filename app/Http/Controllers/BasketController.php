<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Basket;
use App\Models\Product;
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

        $addresses = Address::where('user_id', $user->id)->get();

        $basket = Basket::with('product')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('basket', [
            'basket' => $basket,
            'addresses' => $addresses,
            'products' => Product::limit(10)->get(),
        ]);
    }

    /**
     * List user basket with API product data
     */
    public function listAjax()
    {
        $user = Auth::user();

        $basket = $user->basket()
            ->with('product')
            ->orderBy('created_at', 'desc')
            ->get();

        $basketWithData = $basket->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'product' => $item->product ? [
                    'code' => $item->product->code,
                    'name' => $item->product->name,
                    'price' => $item->product->price_with_vat ?? $item->product->price_without_vat,
                    'media' => $item->product->media ?? [],
                    'tags' => $item->product->tags ?? [],
                ] : null,
                'quantity' => $item->quantity,
                'added_at' => $item->created_at,
            ];
        });

        return response()->json($basketWithData);
    }


    /**
     * Add product to basket
     */
    public function add($productId, Request $request): JsonResponse
    {
        $user = Auth::user();

        //  $apiProducts = products();
        //$productData = collect($apiProducts)->firstWhere('id', $productId);
        $productData = Product::where('code', $productId)->first();
        $quantity = $request->input('quantity', 1);
        if (!$productData) {
            return response()->json([
                'success' => 404,
                'message' => __('Product not found.'),
            ], 404);
        }

        $user->basket()->updateOrCreate(
            ['product_id' => $productId],
            ['user_id' => $user->id,
             'quantity' => $quantity]
        );

        return response()->json([
            'success' => 200,
            'message' => __('Product added to basket.'),
            'data' => $productData,
        ]);
    }

    public function updateQuantity($productId, Request $request): JsonResponse
    {
        $user = Auth::user();
        $increment = $request->input('increment', 1);

        $basketItem = $user->basket()->with('product')->where('product_id', $productId)->first();

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
            $basketItem->delete();
            return response()->json([
                'success' => 200,
                'message' => __('Product removed from basket.'),
                'deleted' => true,
            ]);
        }

        $productData = $basketItem->product ? [
            'id' => $basketItem->product->id,
            'code' => $basketItem->product->code,
            'name' => $basketItem->product->name,
            'price' => $basketItem->product->price_with_vat ?? $basketItem->product->price_without_vat,
            'media' => $basketItem->product->media ?? [],
            'tags' => $basketItem->product->tags ?? [],
        ] : null;

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
    public function delete($productId): JsonResponse
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
