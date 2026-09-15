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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('title', 150);
            $table->string('code', 50)->nullable()->unique();
            $table->enum('discount_type', ['PERCENTAGE', 'FIXED'])->default('PERCENTAGE');
            $table->decimal('discount_value', 12, 2);
            $table->decimal('max_discount_amount', 12, 2)->nullable();
            $table->decimal('min_order_amount', 12, 2)->default(0);
            $table->json('package_ids')->nullable();
            $table->enum('timer_type', ['STATIC', 'EVERGREEN'])->default('STATIC');
            $table->timestamp('start_time')->nullable();
            $table->timestamp('end_time')->nullable();
            $table->unsignedInteger('evergreen_duration_minutes')->nullable();
            $table->unsignedInteger('usage_limit')->nullable();
            $table->unsignedInteger('per_user_limit')->nullable();
            $table->unsignedInteger('used_count')->default(0);
            $table->boolean('auto_apply')->default(true);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['is_active', 'start_time', 'end_time']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
