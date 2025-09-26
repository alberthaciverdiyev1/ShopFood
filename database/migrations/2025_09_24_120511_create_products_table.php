<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('name_alt_a')->nullable();
            $table->string('name_alt_b')->nullable();
            $table->string('name_alt_c')->nullable();
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->string('barcode')->nullable();
            $table->decimal('price_with_vat', 15, 4)->nullable();
            $table->decimal('price_without_vat', 15, 4)->nullable();
            $table->decimal('vat_rate', 5, 2)->nullable();
            $table->decimal('purchase_price', 15, 4)->nullable();
            $table->string('unit')->nullable();
            $table->string('weight_unit')->nullable();
            $table->integer('stock_total')->default(0);
            $table->integer('stock_reserved')->default(0);
            $table->integer('stock_available')->default(0);
            $table->boolean('is_stocked')->default(true);
            $table->string('category')->nullable();
            $table->string('country')->nullable();

            // JSON alanlar
            $table->json('tags')->nullable();
            $table->json('external_ids')->nullable();
            $table->json('media')->nullable();
            $table->json('warehouses')->nullable();

            $table->boolean('expiry_tracked')->default(false);
            $table->integer('attachments_count')->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
