<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method_used VARCHAR(50) NOT NULL DEFAULT ''");
        } else {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method_used', 50)->change();
            });
        }

        // Fix existing orders where ENUM truncation may have set payment_method_used to empty string
        DB::table('orders')
            ->where('payment_gateway_used', 'doku')
            ->where('payment_method_used', '')
            ->update(['payment_method_used' => 'doku']);
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method_used ENUM('manual_bank', 'midtrans', 'doku') NOT NULL");
        } else {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method_used', 50)->change();
            });
        }
    }
};
