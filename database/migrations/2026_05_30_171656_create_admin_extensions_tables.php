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
        Schema::create('system_configs', function (Blueprint $table) {
            $table->id();
            $table->integer('demo_duration_days')->default(3);
            $table->integer('demo_grace_period_days')->default(30);
            $table->timestamps();
        });

        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('feature_name', 100);
            $table->string('feature_key', 50)->unique();
            $table->decimal('price', 10, 2)->default(0.00);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('addon_invitation', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->cascadeOnDelete();
            $table->foreignId('addon_id')->constrained()->cascadeOnDelete();
            $table->timestamp('purchased_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addon_invitation');
        Schema::dropIfExists('addons');
        Schema::dropIfExists('system_configs');
    }
};
