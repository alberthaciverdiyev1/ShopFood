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
            $data = $this->productData;

            if (empty($data['cenik'])) {
                return;
            }

            $code = str_replace('code:', '', $data['cenik']);

            $product = Product::where('code', $code)->first();

            if (!$product) {
                return;
            }

            //   $warehouses = collect($product->warehouses ?? []);
            $warehouses = collect();

            $warehouseCode = str_replace('code:', '', $data['sklad'] ?? '');
            $warehouseName = $data['sklad@showAs'] ?? null;
            $stock = (float)($data['stavMjSPozadavky'] ?? 0);

//            $index = $warehouses->search(
//                fn ($w) => ($w['warehouse_code'] ?? null) === $warehouseCode
//            );

//            if ($index !== false) {
            if (false) {
                $warehouses[$index]['stock'] = $stock;
            } else {
//                $warehouses->push([
//                    'warehouse_code' => $warehouseCode,
//                    'warehouse_name' => $warehouseName,
//                    'stock' => $stock,
//                ]);

                $warehouses = [
                    [
                        'warehouse_code' => $warehouseCode,
                        'warehouse_name' => $warehouseName,
                        'stock'          => $stock,
                    ],
                ];
            }

            $totalStock = 0;
            $reserved = 0;

            foreach ($warehouses as $w) {
                $s = (float)($w['stock'] ?? 0);
                $s < 0 ? $reserved += abs($s) : $totalStock += $s;
            }


//            $product->update([
//                'warehouses' => $warehouses->values()->toArray(),
//                'stock_total' => $totalStock,
//                'stock_reserved' => $reserved,
//                'stock_available' => max($totalStock - $reserved, 0),
//                'is_stocked' => $totalStock > 0,
//            ]);

            $product->update([
                'warehouses'      => $warehouses,
                'stock_total'     => max($stock, 0),
                'stock_reserved'  => $stock < 0 ? abs($stock) : 0,
                'stock_available' => max($stock, 0),
                'is_stocked'      => $stock > 0,
            ]);

        } catch (\Throwable $e) {
            Log::error('Update product stock failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ]);
        }
    }

}
