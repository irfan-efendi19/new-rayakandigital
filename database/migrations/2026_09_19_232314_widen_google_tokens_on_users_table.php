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
        Schema::table('users', function (Blueprint $table) {
            $table->text('google_token')->nullable()->change();
            $table->text('google_refresh_token')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::table('users')->whereRaw('LENGTH(google_token) > 255')
            ->orWhereRaw('LENGTH(google_refresh_token) > 255')->exists()) {
            throw new RuntimeException('Cannot shrink Google token columns while tokens longer than 255 characters exist.');
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('google_token')->nullable()->change();
            $table->string('google_refresh_token')->nullable()->change();
        });
    }
};
