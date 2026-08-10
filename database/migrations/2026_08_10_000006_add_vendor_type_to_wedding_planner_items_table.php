<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wedding_planner_items', function (Blueprint $table) {
            $table->string('vendor_type', 50)->nullable()->after('category');
        });
    }

    public function down(): void
    {
        Schema::table('wedding_planner_items', function (Blueprint $table) {
            $table->dropColumn('vendor_type');
        });
    }
};
