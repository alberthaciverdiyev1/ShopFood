<?php

namespace Database\Seeders;

use App\Models\ExchangeRate;
use App\Models\PrivacyPolicy;
use App\Models\Setting;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        PrivacyPolicy::create([
            'content' => 'Privacy Policy Content',
        ]);
        ExchangeRate::create([
            'rate' => 1,
            'currency' => 'EUR',
        ]);
        ExchangeRate::create([
            'rate' => 1,
            'currency' => 'Czech Koruna',
        ]);

        Setting::create([
            'whatsapp_link' => 'https://wa.me/994709990569',
            'telegram_link' => 'https://t.me/test',
        ]);
        // User::factory(10)->create();
/*
        User::factory()->create([
            'contact_name' => 'Test User',
            'email' => 'test@example.com',
        ]);*/
    }
}
