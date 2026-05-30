<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_method_configs', function (Blueprint $table) {
            $table->id();
            $table->enum('active_method', ['manual_bank', 'midtrans'])->default('manual_bank');

            $table->string('manual_bank_name', 50)->nullable();
            $table->string('manual_account_number', 50)->nullable();
            $table->string('manual_account_name', 100)->nullable();
            $table->string('admin_whatsapp_number', 20)->nullable();

            $table->text('midtrans_client_key')->nullable();
            $table->text('midtrans_server_key')->nullable();
            $table->enum('midtrans_environment', ['sandbox', 'production'])->default('sandbox');

            $table->timestamp('updated_at')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_method_configs');
    }
};
