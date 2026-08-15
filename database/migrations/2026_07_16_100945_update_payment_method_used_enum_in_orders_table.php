<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method_used ENUM('manual_bank', 'midtrans', 'doku') NOT NULL");
        } else {
            Schema::table('orders', function (Blueprint $table) {
                $table->string('payment_method_used')->change();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            // Reverting might fail if there are 'doku' records, so be cautious
            // \Illuminate\Support\Facades\DB::statement("ALTER TABLE orders MODIFY COLUMN payment_method_used ENUM('manual_bank', 'midtrans') NOT NULL");
        }
    }
};
