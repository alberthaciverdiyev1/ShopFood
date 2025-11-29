<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * List user orders with API product data
     */
//    public function list()
//    {
//        $user = Auth::user();
//
//        $orders = Order::with('items')
//            ->where('user_id', $user->id)
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
//        return response()->json($ordersWithData);
//        return view('orders', [
//            'orders' => $ordersWithData,
//            'products' => $apiProducts,
//        ]);
//    }
    public function list()
    {
        $user = Auth::user();

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get(); // paginate yok

        $ordersWithData = $orders->map(function ($order) {
            $items = $order->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product'    => $item->product,
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->total,
                ];
            });

            return [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'status'       => $order->status,
                'total_price'  => $order->total_price,
                'items'        => $items,
                'created_at'   => $order->created_at,
            ];
        });

        // JSON için
        if (request()->wantsJson()) {
            return response()->json($ordersWithData);
        }

        // View için
        return view('orders', [
            'orders' => $ordersWithData
        ]);
    }

    /**
     * List user orders (AJAX / JSON)
     */
    public function listAjax()
    {
        $user = Auth::user();

        $orders = Order::with(['items.product'])
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $ordersWithData = $orders->map(function ($order) {
            $items = $order->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,   // Product::code
                    'product'    => Product::where('product_id',$item->product_id)->get(),      // relation üzerinden Product modeli
                    'quantity'   => $item->quantity,
                    'price'      => $item->price,
                    'total'      => $item->total,
                ];
            });

            return [
                'order_id'     => $order->id,
                'order_number' => $order->order_number,
                'status'       => $order->status,
                'total_price'  => $order->total_price,
                'items'        => $items,
                'created_at'   => $order->created_at,
            ];
        });

        return response()->json($ordersWithData);
    }

//    public function add(Request $request): JsonResponse
//    {
//        $user = Auth::user();
//
//        if ($user->basket->isEmpty()) {
//            return response()->json([
//                'success' => 400,
//                'message' => __('Your basket is empty.'),
//            ], 400);
//        }
//
//        $totalPrice = 0;
//        $orderItems = [];
//
//        foreach ($user->basket as $basketItem) {
//            $product = $basketItem->product;
//
//            if (!$product) {
//                return response()->json([
//                    'success' => 404,
//                    'message' => "Product with code {$basketItem->product_id} not found",
//                ], 404);
//            }
//
//            $price = $product->price_with_vat ?? 0;
//            $quantity = $basketItem->quantity ?? 1;
//            $total = $price * $quantity;
//
//            $totalPrice += $total;
//
//            $orderItems[] = [
//                'product_id' => $basketItem->product_id,
//                'quantity'   => $quantity,
//                'price'      => $price,
//                'total'      => $total,
//            ];
//        }
//
//        $order = \App\Models\Order::create([
//            'user_id'       => $user->id,
//            'order_number'  => strtoupper(uniqid("ORD-", true)),
//            'status'        => 'pending',
//            'address'       => $request->input('address') ?? null,
//            'self_delivery' => $request->boolean('selfDelivery') ?? false,
//            'payment_method'=> $request->input('payment'),
//            'note_to_admin' => $request->input('noteToAdmin'),
//            'total_price'   => $totalPrice,
//        ]);
//
//        foreach ($orderItems as $orderItem) {
//            $order->items()->create($orderItem);
//        }
//
//        $user->basket()->delete();
//
//        return response()->json([
//            'success' => 200,
//            'message' => __('Order created successfully.'),
//            'order_id' => $order->id,
//        ]);
//    }

    public function add(Request $request): JsonResponse
    {
        $user = Auth::user();

        if ($user->basket->isEmpty()) {
            return response()->json([
                'success' => 400,
                'message' => __('Your basket is empty.'),
            ], 400);
        }

        $totalPrice = 0;
        $orderItems = [];

        foreach ($user->basket as $basketItem) {
            $product = $basketItem->product;

            if (!$product) {
                return response()->json([
                    'success' => 404,
                    'message' => "Product with code {$basketItem->product_id} not found",
                ], 404);
            }

            $price = $product->price_with_vat ?? 0;
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

        // LOCAL ORDER CREATE
        $order = \App\Models\Order::create([
            'user_id'       => $user->id,
            'order_number'  => strtoupper(uniqid("ORD-", true)),
            'status'        => 'pending',
            'address'       => $request->input('address') ?? null,
            'self_delivery' => $request->boolean('selfDelivery') ?? false,
            'payment_method'=> $request->input('payment'),
            'note_to_admin' => $request->input('noteToAdmin'),
            'total_price'   => $totalPrice,
        ]);

        foreach ($orderItems as $orderItem) {
            $order->items()->create($orderItem);
        }

        // FLEXIBEE ORDER SYNC BAŞLAYIR
        try {
            $flexItems = [];

            foreach ($orderItems as $item) {
                $flexItems[] = [
                    "kod"      => $item['product_id'],    // Flexibee product code
                    "mnozMj"   => $item['quantity'],       // Quantity
                    "cenaMj"   => $item['price'],          // Price
                    "typPolozkyK" => "typ:polozka",        // Flexibee default
                ];
            }

            $payload = [
                "winstrom" => [
                    "objednavka-prijata" => [
                        [
                            "kod"         => $order->order_number,
                            "firma"       => $user->id,
                            "sumCelkem"   => $totalPrice,
                            "popis"       => $request->input('noteToAdmin'),
                            "typDokl"     => "code:OBJEDNAVKA",
                            "polozkyObchDokladu" => $flexItems
                        ]
                    ]
                ]
            ];

            $flexUrl = "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/objednavka-prijata.json";

            $response = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->timeout(30)
                ->withoutVerifying()
                ->post($flexUrl, $payload);

            if (!$response->successful()) {
                Log::error("Flexibee Order Sync Failed", [
                    'order_id' => $order->id,
                    'response' => $response->body()
                ]);
            } else {
                Log::info("Flexibee Order Synced Successfully", [
                    'order_id' => $order->id,
                    'flexibee' => $response->json()
                ]);
            }

        } catch (\Exception $e) {
            Log::error("Flexibee Sync Exception: " . $e->getMessage(), [
                'order_id' => $order->id
            ]);
        }

        // CLEAR BASKET
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

    public function details(int $id)
    {
        $order = Order::with(['items', 'user'])->findOrFail($id);

        $address = Address::find($order->address);

        $order->address = $address;
        return view('admin.order.details', compact('order'));
    }



}
