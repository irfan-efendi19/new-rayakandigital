<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wedding_checklists', function (Blueprint $table) {
            $table->boolean('is_completed_pria')->default(false)->after('is_completed');
            $table->boolean('is_completed_wanita')->default(false)->after('is_completed_pria');
            $table->boolean('is_document')->default(false)->after('is_preset');
        });
    }

    public function down(): void
    {
        Schema::table('wedding_checklists', function (Blueprint $table) {
            $table->dropColumn(['is_completed_pria', 'is_completed_wanita', 'is_document']);
        });
    }
};
