<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->string('reg_number')->nullable();     // ИНН Регистрационный номер
            $table->string('tax_number')->nullable();     // ДРН (VAT) Налоговый номер
            $table->string('phone')->nullable();          // Телефон

            $table->string('street')->nullable();         // Улица, дом
            $table->string('city')->nullable();           // Город
            $table->string('country')->nullable();        // Страна
            $table->string('zip')->nullable();            // Индекс

            $table->string('contact_name')->nullable();   // Имя, Фамилия
            $table->string('contact_phone')->nullable();  // Телефон

            $table->boolean('is_active')->default(false);

            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
