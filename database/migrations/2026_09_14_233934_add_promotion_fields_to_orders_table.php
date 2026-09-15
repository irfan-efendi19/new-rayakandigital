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
        Schema::table('orders', function (Blueprint $table) {
            $table->foreignId('promotion_id')->nullable()->constrained()->restrictOnDelete();
            $table->string('promotion_title', 150)->nullable();
            $table->string('promotion_code', 50)->nullable();
            $table->decimal('original_amount', 12, 2)->nullable();
            $table->decimal('discount_amount', 12, 2)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropConstrainedForeignId('promotion_id');
            $table->dropColumn(['promotion_title', 'promotion_code', 'original_amount', 'discount_amount']);
        });
    }
};
