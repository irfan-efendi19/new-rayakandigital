<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('whatsapp_gateway_settings', function (Blueprint $table) {
            $table->id();
            $table->string('provider_name');
            $table->text('api_url');
            $table->text('api_token');
            $table->string('device_id')->nullable();
            $table->integer('delay_seconds')->default(3);
            $table->boolean('is_active')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('whatsapp_gateway_settings');
    }
};
