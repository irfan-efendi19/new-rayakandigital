<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('orders', 'payment_method_used')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->enum('payment_method_used', ['manual_bank', 'midtrans'])->after('package_type');
            });

            DB::statement("UPDATE orders SET payment_method_used = 'midtrans' WHERE payment_gateway_used = 'midtrans' OR COALESCE(is_manual_whatsapp, 0) = 0");
            DB::statement("UPDATE orders SET payment_method_used = 'manual_bank' WHERE payment_gateway_used = 'manual_whatsapp' OR COALESCE(is_manual_whatsapp, 0) = 1");
        }

        $indexes = DB::select("SHOW INDEX FROM orders WHERE Key_name = 'idx_payment_routing'");
        if (empty($indexes)) {
            Schema::table('orders', function (Blueprint $table) {
                $table->index(['payment_method_used', 'payment_status'], 'idx_payment_routing');
            });
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('idx_payment_routing');
            $table->dropColumn('payment_method_used');
        });
    }
};
