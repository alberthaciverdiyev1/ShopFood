<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProcessFlexibeeProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $productData;

    public function __construct(array $productData)
    {
        $this->productData = $productData;
    }

    public function handle(): void
    {
        try {
            $priceData = $this->productData;
            $productMedia = [];


            foreach ($priceData['prilohy'] ?? [] as $m) {
                $url = "https://shop-food.flexibee.eu/c/shop_food_s_r_o_/priloha/{$m['id']}/content";

                try {
                    $ext = pathinfo($m['nazSoub'] ?? 'file.jpg', PATHINFO_EXTENSION) ?: 'jpg';
                    $filename = "products/{$m['id']}.$ext";
                    $path = Storage::disk('public')->path($filename);

                    Http::withBasicAuth('shopify_integration2', 'Salam123!')
                        ->withoutVerifying()
                        ->withOptions(['sink' => $path, 'timeout' => 300])
                        ->get($url);

                    $productMedia[] = [
                        'path' => $filename,
                        'url'  => Storage::url($filename),
                    ];
                } catch (\Exception $e) {
                    Log::error("Media download failed for {$url}: " . $e->getMessage());
                }
            }

//            $warehouses = collect($priceData['odberatele'] ?? [])
//                ->map(fn($w) => [
//                    'id'       => $w['id'] ?? null,
//                    'name'     => $w['stredisko@showAs'] ?? null,
//                    'currency' => $w['mena@showAs'] ?? null,
//                    'price'    => $w['prodejCena'] ?? null,
//                ])
//                ->values()
//                ->toArray();

            $warehouses = [];

            $code = str_replace('code:', '', $priceData['kod'] ?? '');


            $category = null;
            $subcategory = null;
            $sticker = null;

            if (!empty($priceData['atributy'])) {
                foreach ($priceData['atributy'] as $attr) {
                    $type = trim($attr['typAtributu'] ?? '');
                    $showAs = trim($attr['typAtributu@showAs'] ?? '');
                    $value = trim($attr['valString'] ?? $attr['hodnota'] ?? '');

                    if (empty($value)) {
                        continue;
                    }

                    if ( stripos($type, 'SUBCATEGORY') !== false || stripos($showAs, 'SUBCATEGORY') !== false ) {
                        $subcategory = $value;
                        continue;
                    }

                    if (stripos($type, 'CATEGORY') !== false ||  stripos($showAs, 'CATEGORY') !== false ) {
                        if (empty($subcategory)) {
                            $category = $value;
                        }
                    }
                    if (stripos($type, 'AKCE') !== false || stripos($showAs, 'AKCE') !== false) {
                        $sticker = $value;
                        continue;
                    }
                }
            }



            if (!$category && !empty($priceData['skupZboz@showAs'])) {
                $parts = explode(':', $priceData['skupZboz@showAs'], 2);
                $category = trim($parts[1] ?? $parts[0]);
            }

//            Log::info("🧭 Kategori tespiti:", [
//                'code' => $priceData['kod'] ?? null,
//                'category' => $category,
//                'subcategory' => $subcategory,
//            ]);

            Product::updateOrCreate(
                ['code' => $code],
                [
                    'name'               => $priceData['nazev'] ?? $code,
                    'name_alt_a'         => $priceData['nazevA'] ?? null,
                    'name_alt_b'         => $priceData['nazevB'] ?? null,
                    'name_alt_c'         => $priceData['nazevC'] ?? null,
                    'description'        => $priceData['popis'] ?? null,
                    'notes'              => $priceData['poznam'] ?? null,
                    'barcode'            => $priceData['eanKod'] ?? null,
                    'price_unit'         => $priceData['cena2'] ?? null,
                    'price_box'          => $priceData['cena3'] ?? null,
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

                    'dph'                => $priceData['typSzbDphK@showAs'] ?? false,

                    'category'           => $category,
                    'subcategory'        => $subcategory,

                    'sticker'            => $sticker,

                    'country'            => $priceData['stat@showAs'] ?? null,
                    'tags'               => array_filter(explode(',', $priceData['stitky'] ?? '')),
                    'expiry_tracked'     => filter_var($priceData['evidExpir'] ?? false, FILTER_VALIDATE_BOOLEAN),
                    'attachments_count'  => $priceData['pocetPriloh'] ?? 0,
                    'external_ids'       => $priceData['external-ids'] ?? [],
                    'media'              => $productMedia,
                    'warehouses'         => $warehouses,
                    'sale_type_1' => $priceData['baleniNazev1'] ?? null,
                    'sale_type_2' => $priceData['baleniNazev2'] ?? null,
                    'sale_type_3' => $priceData['baleniNazev3'] ?? null,
                    'sale_type_4' => $priceData['baleniNazev4'] ?? null,
                    'sale_type_5' => $priceData['baleniNazev5'] ?? null,

                    'type_1_count' => $priceData['baleniMj1'] ?? null,
                    'type_2_count' => $priceData['baleniMj2'] ?? null,
                    'type_3_count' => $priceData['baleniMj3'] ?? null,
                    'type_4_count' => $priceData['baleniMj4'] ?? null,
                    'type_5_count' => $priceData['baleniMj5'] ?? null,
                    'updated_at'         => $priceData['lastUpdate'],
                    'created_at'         => $priceData['lastUpdate']
                ]
            );

        } catch (\Exception $e) {
            Log::error("ProcessFlexibeeProduct failed: " . $e->getMessage());
        }
    }
}
