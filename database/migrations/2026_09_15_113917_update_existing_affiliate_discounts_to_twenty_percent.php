<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('system_configs')
            ->where('affiliate_discount_rate', 5)
            ->update(['affiliate_discount_rate' => 20]);

        DB::table('promotions')
            ->whereNotNull('affiliate_id')
            ->where('discount_type', 'PERCENTAGE')
            ->where('discount_value', 5)
            ->update(['discount_value' => 20]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('system_configs')
            ->where('affiliate_discount_rate', 20)
            ->update(['affiliate_discount_rate' => 5]);

        DB::table('promotions')
            ->whereNotNull('affiliate_id')
            ->where('discount_type', 'PERCENTAGE')
            ->where('discount_value', 20)
            ->update(['discount_value' => 5]);
    }
};
