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

class FetchFlexibeeData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $start;
    protected int $batchSize;
    protected bool $only_warehouse = false;

    public function __construct(int $start = 0, int $batchSize = 20, bool $only_warehouse = false)
    {
        $this->start = $start;
        $this->batchSize = $batchSize;
        $this->only_warehouse = $only_warehouse;
    }

    public function handle(): void
    {
        Log::info("test ".$this->only_warehouse);
        ini_set('memory_limit', '1024M');

        try {
            $tmpDir = storage_path('app/tmp');
            if (!is_dir($tmpDir)) mkdir($tmpDir, 0755, true);

            $tempFile = $tmpDir . "/flexibee_{$this->start}.json";

            Http::withBasicAuth('shopify_integration2', 'Salam123!')
                ->withoutVerifying()
                ->withOptions(['sink' => $tempFile, 'timeout' => 600])
                ->get('https://shop-food.flexibee.eu/c/shop_food_s_r_o_/cenik.json', [
                    'limit' => $this->batchSize,
                    'start' => $this->start,
                    'detail' => 'full',
                    'relations' => 'prilohy,atributy',
                ]);

            $content = file_get_contents($tempFile);
            $data = json_decode($content, true);
            $prices = $data['winstrom']['cenik'] ?? [];
            $count = count($prices);

            foreach ($prices as $priceData) {
                if ($this->only_warehouse) {
                    WarehouseUpdater::dispatch($priceData);
                } else {
                    ProcessFlexibeeProduct::dispatch($priceData);
                }
            }

            @unlink($tempFile);

            if ($count === $this->batchSize) {
                dispatch(new self($this->start + $this->batchSize, $this->batchSize));
            }
            if (!$this->only_warehouse) {
                CompressImage::dispatch();
            }

            Log::info("Fetched {$count} records starting at {$this->start}");
        } catch (\Exception $e) {
            Log::error("Flexibee job failed: " . $e->getMessage());
        }
    }
}
