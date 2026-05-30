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
        Schema::table('invitations', function (Blueprint $table) {
            $table->json('gallery_photos')->nullable();
            $table->string('music_url')->nullable();
            $table->string('gift_bank_name')->nullable();
            $table->string('gift_bank_account')->nullable();
            $table->string('gift_bank_holder')->nullable();
            $table->string('gift_ewallet_name')->nullable();
            $table->string('gift_ewallet_number')->nullable();
            $table->string('gift_qris_image')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'gallery_photos',
                'music_url',
                'gift_bank_name',
                'gift_bank_account',
                'gift_bank_holder',
                'gift_ewallet_name',
                'gift_ewallet_number',
                'gift_qris_image',
            ]);
        });
    }
};
