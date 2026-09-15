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
        Schema::table('system_configs', function (Blueprint $table) {
            $table->decimal('affiliate_discount_rate', 5, 2)->default(20)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('system_configs', function (Blueprint $table) {
            $table->decimal('affiliate_discount_rate', 5, 2)->default(5)->change();
        });
    }
};
