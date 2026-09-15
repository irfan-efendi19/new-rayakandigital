<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Promo type is now determined by whether `code` is null (automatic) or filled (manual voucher).
     * The `auto_apply` boolean column is no longer needed.
     */
    public function up(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->dropColumn('auto_apply');
        });
    }

    public function down(): void
    {
        Schema::table('promotions', function (Blueprint $table) {
            $table->boolean('auto_apply')->default(true)->after('per_user_limit');
        });
    }
};
