<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Intervention\Image\ImageManager;
use Exception;

class CompressImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $directory;

    public function __construct(string $directory = null)
    {
        $this->directory = $directory ?? storage_path('app/public/products/');
    }

    public function handle(): void
    {
        if (!File::exists($this->directory)) {
            throw new Exception("Directory {$this->directory} does not exist.");
        }

        $files = File::files($this->directory);

        $imageManager = new ImageManager(['driver' => 'gd']);
        $compressionPercent = 80;

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $ext = strtolower($file->getExtension());

            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'bmp', 'gif', 'webp'])) {
                continue;
            }

            $mime = mime_content_type($filePath);

            if (!in_array($mime, [
                'image/jpeg',
                'image/png',
                'image/webp',
                'image/gif',
                'image/bmp',
            ])) {
                \Log::error("Skipping invalid image: {$filePath} ({$mime})");
                continue;
            }

            $flagPath = $filePath . '.compressed';
            if (File::exists($flagPath)) {
                continue;
            }

            try {
                $imageManager
                    ->make($filePath)
                    ->orientate()
                    ->save($filePath, $compressionPercent);

                File::put($flagPath, '1');

            } catch (\Throwable $e) {
                \Log::error("Image compression failed for {$filePath}: {$e->getMessage()}");
            }
        }

    }

}
