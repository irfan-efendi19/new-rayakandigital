<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wedding_planner_items', function (Blueprint $table) {
            $table->string('subcategory')->nullable()->after('category');
            $table->decimal('cost_pria', 15, 2)->default(0)->after('paid_amount');
            $table->decimal('cost_wanita', 15, 2)->default(0)->after('cost_pria');
        });
    }

    public function down(): void
    {
        Schema::table('wedding_planner_items', function (Blueprint $table) {
            $table->dropColumn(['subcategory', 'cost_pria', 'cost_wanita']);
        });
    }
};
