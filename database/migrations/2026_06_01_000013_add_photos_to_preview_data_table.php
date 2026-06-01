<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->string('bride_photo')->nullable()->after('groom_name');
            $table->string('groom_photo')->nullable()->after('bride_photo');
        });
    }

    public function down(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->dropColumn(['bride_photo', 'groom_photo']);
        });
    }
};
