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
            $table->string('price_with_vat')->nullable();
            $table->string('price_without_vat')->nullable();
            $table->string('vat_rate')->nullable();
            $table->string('purchase_price')->nullable();
            $table->string('unit')->nullable();
            $table->string('weight_unit')->nullable();
            $table->string('stock_total')->default(0);
            $table->string('stock_reserved')->default(0);
            $table->string('stock_available')->default(0);
            $table->boolean('is_stocked')->default(true);
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();

            $table->string('country')->nullable();
            $table->string('sticker')->nullable();

            $table->string('sale_type_1')->nullable();
            $table->string('sale_type_2')->nullable();
            $table->string('sale_type_3')->nullable();
            $table->string('sale_type_4')->nullable();
            $table->string('sale_type_5')->nullable();

            $table->string('price_unit')->nullable();
            $table->string('price_box')->nullable();

            $table->string('type_1_count')->nullable();
            $table->string('type_2_count')->nullable();
            $table->string('type_3_count')->nullable();
            $table->string('type_4_count')->nullable();
            $table->string('type_5_count')->nullable();

            $table->string('dph')->nullable();
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
