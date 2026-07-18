<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('screen_presets', function (Blueprint $table) {
            $table->longText('html_content')->nullable()->after('thumbnail_image');
        });

        Schema::table('screen_presets', function (Blueprint $table) {
            $table->dropColumn('view_path');
        });
    }

    public function down(): void
    {
        Schema::table('screen_presets', function (Blueprint $table) {
            $table->string('view_path')->after('thumbnail_image');
        });

        Schema::table('screen_presets', function (Blueprint $table) {
            $table->dropColumn('html_content');
        });
    }
};
