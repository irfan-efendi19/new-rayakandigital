<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->string('thumbnail_landscape')->nullable()->after('thumbnail');
            $table->string('thumbnail_portrait')->nullable()->after('thumbnail_landscape');
        });
    }

    public function down(): void
    {
        Schema::table('themes', function (Blueprint $table) {
            $table->dropColumn(['thumbnail_landscape', 'thumbnail_portrait']);
        });
    }
};
