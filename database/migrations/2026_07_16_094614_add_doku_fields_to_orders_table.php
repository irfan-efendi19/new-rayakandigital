<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('doku_va_number', 30)->nullable()->after('snap_token');
            $table->string('doku_channel_code', 50)->nullable()->after('doku_va_number');
            $table->timestamp('doku_expired_at')->nullable()->after('doku_channel_code');
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method_used ENUM('manual_bank', 'midtrans', 'doku') NOT NULL");
        } else {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method_used')->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['doku_va_number', 'doku_channel_code', 'doku_expired_at']);
        });
    }
};
