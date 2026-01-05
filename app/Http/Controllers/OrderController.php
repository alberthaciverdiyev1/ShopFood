<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
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
            ->get();

        $ordersWithData = $orders->map(function ($order) {
            $items = $order->items->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'product' => $item->product,
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
        if (request()->wantsJson()) {
            return response()->json($ordersWithData);
        }

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
                    'product_id' => $item->product_id,
                    'product' => Product::where('product_id', $item->product_id)->get(),
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

//
//bunu saxla. bu isleyir
//
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
//            $price = ($basketItem['type'] === "piece")? $product->price_unit : $product->price_box;
//
//            $quantity = ($basketItem['type'] === "piece") ? $basketItem->quantity : $basketItem->box_items_count;
//
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
//        $safeOrderNumber = 'ORD-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 8));
//
//        $order = \App\Models\Order::create([
//            'user_id'       => $user->id,
//            'order_number'  => $safeOrderNumber,
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
//        try {
//            $flexCustomerCode = "CUST-" . $user->email;
//
//            $flexItems = [];
//            foreach ($orderItems as $item) {
//                $flexItems[] = [
//                    "kod"    => $item['product_id'],
//                    "mnozMj" => $item['quantity'],
//                    "cenaMj" => $item['price']
//                ];
//            }
//
//            $orderPayload = [
//                "winstrom" => [
//                    "objednavka-prijata" => [
//                        [
//                            "kod"         => $safeOrderNumber,
//                            "firma"       => "code:$flexCustomerCode",
//                            "popis"       => $request->input('noteToAdmin'),
//                            "typDokl"     => "code:OBP",
//                            "polozkyObchDokladu" => $flexItems
//                        ]
//                    ]
//                ]
//            ];
//
//            $flexOrderUrl = "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/objednavka-prijata.json";
//
//            $response = Http::withBasicAuth('shopify_integration2', 'Salam123!')
//                ->timeout(30)
//                ->withoutVerifying()
//                ->withOptions(['allow_redirects' => false])
//                ->post($flexOrderUrl, $orderPayload);
//
//            if (!$response->successful()) {
//                Log::error("Flexibee Order Sync Failed", [
//                    'order_id' => $order->id,
//                    'response' => $response->body()
//                ]);
//            } else {
//                Log::info("Flexibee Order Synced Successfully", [
//                    'order_id' => $order->id,
//                    'flexibee' => $response->json()
//                ]);
//            }
//
//        } catch (\Exception $e) {
//            Log::error("Flexibee Sync Exception: " . $e->getMessage(), [
//                'order_id' => $order->id
//            ]);
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

        $ordersByWarehouse = [];

        foreach ($user->basket as $basketItem) {

            $product = $basketItem->product;

            if (!$product) {
                return response()->json([
                    'success' => 404,
                    'message' => "Product not found: {$basketItem->product_id}",
                ], 404);
            }

            $price = $basketItem->type === 'piece'
                ? $product->price_unit
                : $product->price_box;

            $quantityNeeded = $basketItem->type === 'piece'
                ? $basketItem->quantity
                : $basketItem->box_items_count;

            // warehouse-ları stokuna görə sırala
            $warehouses = collect($product->warehouses)
                ->filter(fn($w) => ($w['stock'] ?? 0) > 0)
                ->sortByDesc('stock')
                ->values();

            foreach ($warehouses as $warehouse) {

                if ($quantityNeeded <= 0) {
                    break;
                }

                $available = (int)$warehouse['stock'];
                $take = min($available, $quantityNeeded);

                $ordersByWarehouse[$warehouse['warehouse_code']][] = [
                    'product_id' => $product->id,
                    'quantity' => $take,
                    'price' => $price,
                    'total' => $take * $price,
                ];

                $quantityNeeded -= $take;
            }

            if ($quantityNeeded > 0) {
                return response()->json([
                    'success' => 422,
                    'message' => "Insufficient stock for product {$product->code}",
                ], 422);
            }
        }

        $createdOrders = [];

        foreach ($ordersByWarehouse as $warehouseCode => $items) {

            $totalPrice = collect($items)->sum('total');

            $orderNumber = 'ORD-' . strtoupper(substr(bin2hex(random_bytes(6)), 0, 8));

            $order = \App\Models\Order::create([
                'user_id' => $user->id,
                'order_number' => $orderNumber,
                'status' => 'pending',
                'warehouse_code' => $warehouseCode,
                'address' => $request->input('address'),
                'self_delivery' => $request->boolean('selfDelivery'),
                'payment_method' => $request->input('payment'),
                'note_to_admin' => $request->input('noteToAdmin'),
                'total_price' => $totalPrice,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            // FLEXIBEE
            try {
                $flexItems = [];

                foreach ($items as $item) {
                    $flexItems[] = [
                        "kod" => $item['product_id'],
                        "mnozMj" => $item['quantity'],
                        "cenaMj" => $item['price'],
                    ];
                }

                $payload = [
                    "winstrom" => [
                        "objednavka-prijata" => [[
                            "kod" => $orderNumber,
                            "typDokl" => "code:OBP",
                            "sklad" => "code:$warehouseCode",
                            "firma" => "code:CUST-{$user->email}",
                            "popis" => $request->input('noteToAdmin'),
                            "polozkyObchDokladu" => $flexItems,
                        ]]
                    ]
                ];

                Http::withBasicAuth('shopify_integration2', 'Salam123!')
                    ->timeout(30)
                    ->withoutVerifying()
                    ->post(
                        "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/objednavka-prijata.json",
                        $payload
                    );
                Log::info('Flexibee order created successfully');
            } catch (\Throwable $e) {
                Log::error('Flexibee sync failed', [
                    'order_id' => $order->id,
                    'error' => $e->getMessage(),
                ]);
            }

            $createdOrders[] = $order->id;
        }

        // basket-i yalnız axırda sil
        $user->basket()->delete();

        return response()->json([
            'success' => 200,
            'message' => 'Orders created successfully',
            'order_ids' => $createdOrders,
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
