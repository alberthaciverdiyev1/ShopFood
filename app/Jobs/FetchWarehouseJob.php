<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class FetchWarehouseJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, \Illuminate\Bus\Queueable, SerializesModels;

    protected int $start;
    protected int $batchSize;

    public function __construct(int $start = 0, int $batchSize = 20)
    {
        $this->start = $start;
        $this->batchSize = $batchSize;
    }

    public function handle(): void
    {
        Log::info("Warehouse updating started");
        ini_set('memory_limit', '1024M');

        try {
            $tmpDir = storage_path('app/tmp/wh');
            if (!is_dir($tmpDir)) {
                mkdir($tmpDir, 0755, true);
            }

            $tempFile = $tmpDir . "/flexibee_{$this->start}.json";

            Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->withOptions(['sink' => $tempFile, 'timeout' => 600])
                ->get(
                    'https://shop-food.flexibee.eu/c/shop_food_s_r_o_/skladova-karta.json',
                    [
                        'limit' => $this->batchSize,
                        'start' => $this->start,
                    ]
                );

            $content = file_get_contents($tempFile);
            $data = json_decode($content, true);

            $warehouse_data = $data['winstrom']['skladova-karta'] ?? [];
            $count = count($warehouse_data);

            foreach ($warehouse_data as $item) {
                if (($item['sklad'] ?? null) !== 'code:NOVY_SKLAD') {
                    continue;
                }

                WarehouseUpdater::dispatch($item);
            }

            @unlink($tempFile);

            if ($count === $this->batchSize) {
                dispatch(new self($this->start + $this->batchSize, $this->batchSize));
            }

            Log::info("WAREHOUSE :=> Fetched {$count} records starting at {$this->start}");
        } catch (\Exception $e) {
            Log::error("Flexibee job failed: " . $e->getMessage());
        }
    }
}
