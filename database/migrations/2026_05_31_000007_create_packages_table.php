<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('package_code', 30)->unique();
            $table->string('package_name', 50);
            $table->decimal('price', 10, 2)->default(0.00);
            $table->decimal('slashed_price', 10, 2)->nullable()->default(0.00);
            $table->integer('active_period_days')->default(30);
            $table->text('description')->nullable();
            $table->boolean('is_visible')->default(true);
            $table->boolean('is_popular')->default(false);
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('packages');
    }
};
