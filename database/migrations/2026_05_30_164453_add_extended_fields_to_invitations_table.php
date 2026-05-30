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
            $table->string('bride_nickname')->nullable();
            $table->string('groom_nickname')->nullable();
            $table->string('bride_parents')->nullable();
            $table->string('groom_parents')->nullable();
            $table->string('bride_photo')->nullable();
            $table->string('groom_photo')->nullable();
            $table->string('timezone')->default('Asia/Jakarta');
            $table->time('event_time_end')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn([
                'bride_nickname',
                'groom_nickname',
                'bride_parents',
                'groom_parents',
                'bride_photo',
                'groom_photo',
                'timezone',
                'event_time_end',
            ]);
        });
    }
};
