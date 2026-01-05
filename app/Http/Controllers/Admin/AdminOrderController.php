<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class AdminOrderController extends Controller
{
//    public function adminList()
//    {
//        $orders = Order::with('items')
//            ->orderBy('created_at', 'desc')
//            ->paginate(10);
//
//        $apiProducts = products();
//
//        $ordersWithData = $orders->map(function ($order) use ($apiProducts) {
//            $items = $order->items->map(function ($item) use ($apiProducts) {
//                $productData = collect($apiProducts)->firstWhere('id', $item->product_id);
//
//                return [
//                    'product_id' => $item->product_id,
//                    'product' => $productData,
//                    'quantity' => $item->quantity,
//                    'price' => $item->price,
//                    'total' => $item->total,
//                ];
//            });
//
//            return [
//                'order_id' => $order->id,
//                'order_number' => $order->order_number,
//                'status' => $order->status,
//                'total_price' => $order->total_price,
//                'items' => $items,
//                'created_at' => $order->created_at,
//            ];
//
//        });
//        return view('admin.order', [
//            'orders' => $ordersWithData,
//            'products' => $apiProducts,
//        ]);
//    }

    public function adminList()
    {
        $orders = Order::with(['items.product'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $ordersWithData = $orders->map(function ($order) {
            $items = $order->items->map(function ($item) {
                $product = $item->product;
                return [
                    'product_id' => $item->product_id,
                    'product' => $product ? [
                        'id' => $product->id,
                        'code' => $product->code,
                        'name' => $product->name,
                        'price' => $product->price_with_vat ?? $product->price_without_vat,
                        'media' => $product->media ?? [],
                        'tags' => $product->tags ?? [],
                    ] : null,
                    'quantity' => $item->quantity,
                    'price' => $item->price,
                    'total' => $item->total,
                ];
            });

            return [
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'status' => $order->status,
                'total_price' => $order->total_price,
                'items' => $items,
                'created_at' => $order->created_at,
            ];
        });

        return view('admin.order', [
            'orders' => $ordersWithData,
        ]);
    }
    public function update(Request $request, int $orderId): JsonResponse
    {

        $order = \App\Models\Order::where('id', $orderId)
            ->firstOrFail();

        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled,returned',
        ]);

        $order->update(['status' => $data['status']]);

        return response()->json([
            'success' => 200,
            'message' => __('Order updated successfully.'),
            'order' => $order,
        ]);
    }


}
