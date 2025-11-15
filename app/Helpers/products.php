<?php
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

if (!function_exists('products')) {
    function products(Request $request = null)
    {
        try {
            $pricesResponse = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json', [
                    'limit'     => 10,
                    'detail'    => 'full',
                    'relations' => 'prilohy'
                ]);

            $prices = $pricesResponse->json('winstrom.cenik') ?? [];

            $inserted = [];

            foreach ($prices as $priceData) {

                $productMedia = [];
                foreach ($priceData['prilohy'] ?? [] as $m) {
                    $url = "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/priloha/{$m['id']}/content";
                    try {
                        $contents = Http::withBasicAuth('shopify_integration2', 'Salam123!')
                            ->withoutVerifying()
                            ->get($url)
                            ->body();

                        $ext = pathinfo($m['nazev'] ?? 'file.jpg', PATHINFO_EXTENSION) ?: 'jpg';
                        $filename = 'products/' . $m['id'] . '.' . $ext;

                        Storage::disk('public')->put($filename, $contents);

                        $productMedia[] = [
                            'path' => $filename,
                            'url'  => Storage::url($filename)
                        ];

                    } catch (\Exception $e) {
                        Log::error("Media download failed for {$url}: " . $e->getMessage());
                    }
                }

                $warehouses = collect($priceData['odberatele'] ?? [])
                    ->map(fn($w) => [
                        'id'       => $w['id'] ?? null,
                        'name'     => $w['stredisko@showAs'] ?? null,
                        'currency' => $w['mena@showAs'] ?? null,
                        'price'    => $w['prodejCena'] ?? null,
                    ])->values()->toArray();

                $code = str_replace('code:', '', $priceData['kod'] ?? '');

                $product = Product::updateOrCreate(
                    ['code' => $code],
                    [
                        'name'               => $priceData['nazev'] ?? $code,
                        'name_alt_a'         => $priceData['nazevA'] ?? null,
                        'name_alt_b'         => $priceData['nazevB'] ?? null,
                        'name_alt_c'         => $priceData['nazevC'] ?? null,
                        'description'        => $priceData['popis'] ?? null,
                        'notes'              => $priceData['poznam'] ?? null,
                        'barcode'            => $priceData['eanKod'] ?? null,
                        'price_with_vat'     => $priceData['cenaZaklVcDph'] ?? null,
                        'price_without_vat'  => $priceData['cenaZaklBezDph'] ?? null,
                        'vat_rate'           => $priceData['szbDph'] ?? null,
                        'purchase_price'     => $priceData['nakupCena'] ?? null,
                        'unit'               => $priceData['mj1@showAs'] ?? null,
                        'weight_unit'        => $priceData['mjHmot@showAs'] ?? null,
                        'stock_total'        => $priceData['sumStavMj'] ?? 0,
                        'stock_reserved'     => $priceData['sumRezerMj'] ?? 0,
                        'stock_available'    => $priceData['sumDostupMj'] ?? 0,
                        'is_stocked'         => $priceData['skladove'] ?? true,
                        'category'           => $priceData['skupZboz@showAs'] ?? null,
                        'country'            => $priceData['stat@showAs'] ?? null,
                        'tags'               => array_filter(explode(',', $priceData['stitky'] ?? '')),
                        'expiry_tracked'     => filter_var($priceData['evidExpir'] ?? false, FILTER_VALIDATE_BOOLEAN),
                        'attachments_count'  => $priceData['pocetPriloh'] ?? 0,
                        'external_ids'       => $priceData['external-ids'] ?? [],
                        'media'              => $productMedia,
                        'warehouses'         => $warehouses,
                        'updated_at'         => $priceData['lastUpdate'],
                        'created_at'         => $priceData['lastUpdate']
                    ]
                );

                $inserted[] = $product;
            }

            return $inserted;

        } catch (\Exception $e) {
            Log::error('Flexibee fetch/insert error: ' . $e->getMessage());
            return [
                'error'   => true,
                'message' => $e->getMessage()
            ];
        }
    }
}
