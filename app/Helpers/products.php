<?php

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

if (!function_exists('products')) {
    function products(Request $request = null)
    {
        try {
            $flexibeeClient = new Client();

            $url = 'https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json';

            $response = $flexibeeClient->get($url, [
                'auth' => ['shopify_integration2', 'Salam123!'],
                'headers' => ['Accept' => 'application/json'],
                'verify' => false
            ]);

            $flexibeeData = json_decode($response->getBody()->getContents(), true);
            $products = $flexibeeData["winstrom"]["cenik"] ?? [];

            $shopifyClient = new Client([
                'base_uri' => 'https://your-shop-name.myshopify.com/admin/api/2025-01/',
                'auth' => ['shopify_api_key', 'shopify_password']
            ]);

            foreach ($products as &$product) {
//                $product['images'] = [];
                $product['images'] = [
                    'https://shopfood.cz/cdn/shop/files/9434896138547-0.png?v=1756723347&width=1946'
                ];
                $product['description'] = 'Sample product description';

                $productId = null;
                if (!empty($product['external-ids'])) {
                    foreach ($product['external-ids'] as $extId) {
                        if (strpos($extId, 'productId') !== false) {
                            // ext:productId{{gid://shopify/Product/14863446606197}}
                            preg_match('/\d+$/', $extId, $matches);
                            if (!empty($matches[0])) {
                                $productId = $matches[0];
                                break;
                            }
                        }
                    }
                }

                if ($productId) {
                    try {
                        $shopifyResponse = $shopifyClient->get("products/{$productId}/images.json");
                        $shopifyData = json_decode($shopifyResponse->getBody()->getContents(), true);

                        if (!empty($shopifyData['images'])) {
                            foreach ($shopifyData['images'] as $img) {
                                $product['images'][] = $img['src'];
                            }
                        }

                    } catch (\Exception $e) {
                        Log::error("Shopify images fetch error for product {$productId}: " . $e->getMessage());
                        $product['images'] = [];
                    }
                }
            }


            return $products;

        } catch (\Exception $e) {
            Log::error('Products helper error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
if (!function_exists('categories')) {
    function categories(Request $request = null)
    {
        try {
            $client = new Client();

            $url = 'https://shop-food.flexibee.eu/c/shop_food_s_r_o_/kategorie.json'; // Örnek kategori endpoint

            $response = $client->get($url, [
                'auth' => ['shopify_integration2', 'Salam123!'], // Basic Auth
                'headers' => ['Accept' => 'application/json'],
                'verify' => false
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            return $data['winstrom']['kategorie'] ?? [];

        } catch (\Exception $e) {
            Log::error('Categories helper error: ' . $e->getMessage());

            return [
                'success' => false,
                'message' => $e->getMessage()
            ];
        }
    }
}
