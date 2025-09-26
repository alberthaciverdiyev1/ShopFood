<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TestController extends Controller
{
    public function index()
    {
      // return categories();

        try {
            $pricesResponse = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json', [
                    'limit'     => 10,
                    'detail'    => 'full',
                    'relations' => 'prilohy'
                ]);

            $prices = $pricesResponse->json('winstrom.cenik') ?? [];

            $result = [];
            foreach ($prices as $priceData) {
                $productMedia = collect($priceData['prilohy'] ?? [])
                    ->map(function ($m) {
                        return [
                            'url' => "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/priloha/{$m['id']}/content",
                       //     'md5' => $m['content'] ?? ''
                            //'md5' => md5(base64_decode($m['content'] ?? ''))
                        ];
                    })
                    ->values()
                    ->toArray();

                $warehouses = collect($priceData['odberatele'] ?? [])
                    ->map(function ($w) {
                        return [
                            'id'       => $w['id'] ?? null,
                            'name'     => $w['stredisko@showAs'] ?? null,
                            'currency' => $w['mena@showAs'] ?? null,
                            'price'    => $w['prodejCena'] ?? null,
                        ];
                    })
                    ->values()
                    ->toArray();

                $code = str_replace('code:', '', $priceData['kod'] ?? '');

                $result[] = [
                    'code'               => $code, // Product code / SKU
                    'name'               => $priceData['nazev'] ?? $code, // Main name
                    'name_alt_a'         => $priceData['nazevA'] ?? null, // Alternative name A
                    'name_alt_b'         => $priceData['nazevB'] ?? null, // Alternative name B
                    'name_alt_c'         => $priceData['nazevC'] ?? null, // Alternative name C
                    'description'        => $priceData['popis'] ?? null, // Description
                    'notes'              => $priceData['poznam'] ?? null, // Notes
                    'barcode'            => $priceData['eanKod'] ?? null, // Barcode / EAN
                    'price_with_vat'     => $priceData['cenaZaklVcDph'] ?? null, // Price with VAT
                    'price_without_vat'  => $priceData['cenaZaklBezDph'] ?? null, // Price without VAT
                    'vat_rate'           => $priceData['szbDph'] ?? null, // VAT rate %
                    'purchase_price'     => $priceData['nakupCena'] ?? null, // Purchase price
                    'unit'               => $priceData['mj1@showAs'] ?? null, // Unit (e.g., pcs)
                    'weight_unit'        => $priceData['mjHmot@showAs'] ?? null, // Weight unit (e.g., kg)
                    'stock_total'        => $priceData['sumStavMj'] ?? 0, // Total stock
                    'stock_reserved'     => $priceData['sumRezerMj'] ?? 0, // Reserved stock
                    'stock_available'    => $priceData['sumDostupMj'] ?? 0, // Available stock
                    'is_stocked'         => $priceData['skladove'] ?? true, // Is stocked?
                    'category'           => $priceData['skupZboz@showAs'] ?? null, // Product category
                    'country'            => $priceData['stat@showAs'] ?? null, // Country of origin
                    'tags'               => array_filter(explode(',', $priceData['stitky'] ?? '')), // Tags
                    'expiry_tracked'     => filter_var($priceData['evidExpir'] ?? false, FILTER_VALIDATE_BOOLEAN), // Expiry tracking enabled?
                    'attachments_count'  => $priceData['pocetPriloh'] ?? 0, // Number of attachments
                    'external_ids'       => $priceData['external-ids'] ?? [], // External system IDs
                    'media'              => $productMedia, // Media / attachments
                    'warehouses'         => $warehouses, // Warehouses with prices
             //       'all_fields'         => $priceData // All original fields
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
