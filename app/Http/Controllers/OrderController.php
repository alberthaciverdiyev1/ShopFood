<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * List user orders with API product data
     */
    public function list()
    {
        $user = Auth::user();

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $apiProducts = products();

        $ordersWithData = $orders->map(function ($order) use ($apiProducts) {
            $items = $order->items->map(function ($item) use ($apiProducts) {
                $productData = collect($apiProducts)->firstWhere('id', $item->product_id);

                return [
                    'product_id' => $item->product_id,
                    'product' => $productData,
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
return response()->json($ordersWithData);
        return view('orders', [
            'orders' => $ordersWithData,
            'products' => $apiProducts,
        ]);
    }

    /**
     * List user orders (AJAX / JSON)
     */
    public function listAjax()
    {
        $user = Auth::user();

        $orders = Order::with('items')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $apiProducts = products();

        $ordersWithData = $orders->map(function ($order) use ($apiProducts) {
            $items = $order->items->map(function ($item) use ($apiProducts) {
                $productData = collect($apiProducts)->firstWhere('id', $item->product_id);

                return [
                    'product_id' => $item->product_id,
                    'product' => $productData,
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

        return response()->json($ordersWithData);
    }

    public function add(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->basket->isEmpty()) {
            return response()->json([
                'success' => 400,
                'message' => __('Your basket is empty.'),
            ], 400);
        }

        $apiProducts = products();
        $totalPrice = 0;
        $orderItems = [];

        foreach ($user->basket as $basketItem) {
            $product = collect($apiProducts)->firstWhere('id', $basketItem->product_id);

            if (!$product) {
                return response()->json([
                    'success' => 404,
                    'message' => "Product {$basketItem->product_id} not found",
                ], 404);
            }

            $price = $product['price'] ?? 0;
            $quantity = $basketItem->quantity ?? 1;
            $total = $price * $quantity;

            $totalPrice += $total;

            $orderItems[] = [
                'product_id' => $basketItem->product_id,
                'quantity'   => $quantity,
                'price'      => $price,
                'total'      => $total,
            ];
        }

        $order = \App\Models\Order::create([
            'user_id'        => $user->id,
            'order_number'   => strtoupper(uniqid("ORD-", true)),
            'status'         => 'pending',
            'address'        => $request->input('address'),
            'payment_method' => $request->input('payment'),
            'note_to_admin'  => $request->input('noteToAdmin'),
        ]);

        foreach ($orderItems as $orderItem) {
            $order->items()->create($orderItem);
        }

        // səbəti təmizləyirik
        $user->basket()->delete();

        return response()->json([
            'success' => 200,
            'message' => __('Order created successfully.'),
            'order_id' => $order->id,
        ]);
    }




    public function delete(int $orderId): JsonResponse
    {
        $user = Auth::user();

        $order = \App\Models\Order::where('id', $orderId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        $order->delete();

        return response()->json([
            'success' => 200,
            'message' => __('Order deleted successfully.'),
        ]);
    }

}
