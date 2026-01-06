<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchFlexibeeData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $start;
    protected int $batchSize;
    protected bool $onlyWarehouse;
    protected ?string $lastHash;

    public function __construct(
        int $start = 0,
        int $batchSize = 20,
        bool $onlyWarehouse = false,
        ?string $lastHash = null
    ) {
        $this->start = $start;
        $this->batchSize = $batchSize;
        $this->onlyWarehouse = $onlyWarehouse;
        $this->lastHash = $lastHash;
    }

    public function handle(): void
    {
        ini_set('memory_limit', '1024M');

        Log::info("Fetching Flexibee data", [
            'start' => $this->start,
            'limit' => $this->batchSize,
        ]);

        $response = Http::withBasicAuth('shopify_integration2', 'Salam123!')
            ->withoutVerifying()
            ->timeout(600)
            ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json', [
                'limit' => $this->batchSize,
                'start' => $this->start,
                'detail' => 'full',
                'relations' => 'prilohy,atributy',
            ]);

        $prices = $response->json('winstrom.cenik', []);

        $currentHash = md5(json_encode($prices));

        if ($this->lastHash && $this->lastHash === $currentHash) {
            Log::info("Flexibee sync finished (duplicate batch detected)");

            if (!$this->onlyWarehouse) {
                CompressImage::dispatch();
            }

            return;
        }

        foreach ($prices as $priceData) {
            if ($this->onlyWarehouse) {
                WarehouseUpdater::dispatch($priceData);
            } else {
                ProcessFlexibeeProduct::dispatch($priceData);
            }
        }

        self::dispatch(
            $this->start + $this->batchSize,
            $this->batchSize,
            $this->onlyWarehouse,
            $currentHash
        );

        Log::info("Fetched " . count($prices) . " records", [
            'start' => $this->start,
        ]);
    }
}
