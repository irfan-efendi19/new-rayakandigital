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
            $table->enum('payment_status', ['pending', 'verifying', 'success', 'failed', 'expired'])
                ->default('pending')
                ->change();
        });

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'is_manual_whatsapp')) {
                $table->boolean('is_manual_whatsapp')->default(false)->after('payment_gateway_used');
            }
            if (!Schema::hasColumn('orders', 'unique_code')) {
                $table->integer('unique_code')->default(0)->after('gross_amount');
            }
        });

        if (!Schema::hasColumn('orders', 'verified_by')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->unsignedBigInteger('verified_by')->nullable();
            });
        } else {
            DB::statement("ALTER TABLE orders MODIFY verified_by BIGINT UNSIGNED NULL");
        }

        $indexes = DB::select("SHOW INDEX FROM orders WHERE Key_name = 'idx_admin_wa_search'");
        if (empty($indexes)) {
            Schema::table('orders', function (Blueprint $table) {
                $table->index(['unique_code', 'order_id'], 'idx_admin_wa_search');
            });
        }

        $foreignKeys = DB::select("SELECT CONSTRAINT_NAME FROM information_schema.TABLE_CONSTRAINTS WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = 'orders' AND CONSTRAINT_TYPE = 'FOREIGN KEY' AND CONSTRAINT_NAME LIKE '%verified_by%'");
        if (empty($foreignKeys)) {
            DB::statement("ALTER TABLE orders ADD CONSTRAINT orders_verified_by_foreign FOREIGN KEY (verified_by) REFERENCES users(id) ON DELETE SET NULL");
        }
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropIndex('idx_admin_wa_search');
            $table->dropColumn(['is_manual_whatsapp', 'unique_code', 'verified_by']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->enum('payment_status', ['pending', 'success', 'failed', 'expired'])
                ->default('pending')
                ->change();
        });
    }
};
