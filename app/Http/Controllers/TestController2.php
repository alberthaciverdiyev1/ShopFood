<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController2 extends Controller
{
    public function index()
    {
        ini_set('memory_limit', '8048M'); // 2 GB

        try {
            // 1️⃣ Ürün kartları (tüm ürünler)
            $productsResponse = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->timeout(300000)
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/skladova-karta.json', ['limit' => 0]);

            $products = $productsResponse->json('winstrom.skladova-karta') ?? [];
            $pricesResponse = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->timeout(300000)
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json', [
                    'limit' => 0]);

            $prices = $pricesResponse->json('winstrom.cenik') ?? [];
            $priceMap = [];
            foreach ($prices as $price) {
                $priceMap[$price['kod']] = $price;
            }

            // 3️⃣ Media (priloha, tüm medyalar)
            $mediaResponse = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->timeout(300000)
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/priloha.json', ['limit' => 0]);
//return response()->json($mediaResponse->json());
            $media = $mediaResponse->json('winstrom.priloha') ?? [];

            // 🔹 Ürünleri birleştir
            $result = [];
            foreach ($products as $product) {
                $code = isset($product['cenik']) ? str_replace('code:', '', $product['cenik']) : null;
                $priceData = $priceMap[$code] ?? null;

                // Media filtrele (sadece image/jpeg)
             //   return $media;
                $productMedia = collect($media)
                  //  ->where('contentType', 'image/jpeg')
                    ->map(fn($m) => "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/priloha/{$m['id']}/content")
                    ->values()
                    ->toArray();

                // Warehouse bazlı stok bilgisi
                $warehouseStock = [];
                $warehouseCode = $product['sklad@showAs'] ?? 'Unknown';
                $warehouseStock[$warehouseCode] = $product['stavMjSPozadavky'] ?? 0;

                $result[] = [
                    'code'          => $code,
                    'name'          => $priceData['nazev'] ?? ($product['cenik@showAs'] ?? null),
                    'stock'         => $product['stavMjSPozadavky'] ?? null,
                    'warehouseStock'=> $warehouseStock,
                    'price'         => $priceData ? [
                        'with_vat'    => $priceData['cenaZaklVcDph'] ?? null,
                        'without_vat' => $priceData['cenaZaklBezDph'] ?? null,
                        'vat_rate'    => $priceData['szbDph'] ?? null,
                    ] : null,
                    'media'         => $productMedia,
                    'warehouse'     => $warehouseCode,
                    'description'   => $product['popisLong'] ?? $product['popis'] ?? $product['cenik@showAs'] ?? null,
                    'externalIds'   => $priceData['external-ids'] ?? [],
                ];
            }

            return response()->json([
                'success' => true,
                'total'   => count($result),
                'data'    => $result
            ]);

        } catch (\Exception $e) {
            Log::error('Flexibee fetch error: ' . $e->getMessage());
            return response()->json([
                'error'   => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
