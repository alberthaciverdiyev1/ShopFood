<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('is_send_email')->default(0); // 0 = yox, 1 = göndərildi, 2 = başqa status
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('is_send_email');
        });
    }
};
