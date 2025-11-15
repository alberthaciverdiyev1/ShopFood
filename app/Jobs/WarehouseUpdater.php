<?php

namespace App\Jobs;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class WarehouseUpdater implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected array $productData;

    public function __construct(array $productData)
    {
        $this->productData = $productData;
    }

    public function handle(): void
    {
        try {
            $priceData = $this->productData;

\Log::info("Updating warehouses for product data ");
            $warehouses = collect($priceData['odberatele'] ?? [])
                ->map(fn($w) => [
                    'id'       => $w['id'] ?? null,
                    'name'     => $w['stredisko@showAs'] ?? null,
                    'currency' => $w['mena@showAs'] ?? null,
                    'price'    => $w['prodejCena'] ?? null,
                ])->values()->toArray();

            $code = str_replace('code:', '', $priceData['kod'] ?? '');

            Product::updateOrCreate(
                ['code' => $code],
                [
                    'warehouses'         => $warehouses,
                    'stock_total'        => $priceData['sumStavMj'] ?? 0,
                    'stock_reserved'     => $priceData['sumRezerMj'] ?? 0,
                    'stock_available'    => $priceData['sumDostupMj'] ?? 0,
                    'is_stocked'         => $priceData['skladove'] ?? true,
                ]
            );

        } catch (\Exception $e) {
            Log::error("ProcessFlexibeeProduct failed: " . $e->getMessage());
        }
    }
}
