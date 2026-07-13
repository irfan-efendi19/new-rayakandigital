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
        Schema::dropIfExists('payment_gateway_settings');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('payment_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name', 50)->unique();
            $table->text('client_key')->nullable();
            $table->text('server_key')->nullable();
            $table->text('webhook_secret')->nullable();
            $table->enum('environment', ['sandbox', 'production'])->default('sandbox');
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }
};
