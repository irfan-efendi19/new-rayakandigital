<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('package_feature_pivots', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained()->cascadeOnDelete();
            $table->foreignId('feature_id')->constrained('platform_features')->cascadeOnDelete();
            $table->unique(['package_id', 'feature_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_feature_pivots');
    }
};
