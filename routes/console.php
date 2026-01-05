<?php

use App\Jobs\FetchFlexibeeData;
use App\Jobs\FetchWarehouseJob;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Schedule::job(new FetchFlexibeeData(0,20))->timezone('Asia/Baku')->dailyAt('23:00');
Schedule::job(new FetchWarehouseJob(0,20))->timezone('Asia/Baku')->dailyAt('00:00');
