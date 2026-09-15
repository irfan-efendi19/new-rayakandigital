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
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('promotion_usages', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->cascadeOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            return;
        }

        Schema::table('promotion_usages', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->restrictOnDelete();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropForeign(['promotion_id']);
            $table->foreign('promotion_id')
                ->references('id')
                ->on('promotions')
                ->restrictOnDelete();
        });
    }
};
