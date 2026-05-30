<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id', 100)->unique();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('invitation_id')->nullable()->constrained()->onDelete('cascade');
            $table->enum('package_type', ['silver', 'gold', 'platinum', 'addon']);
            $table->decimal('gross_amount', 10, 2);
            $table->enum('payment_status', ['pending', 'success', 'failed', 'expired'])->default('pending');
            $table->string('payment_gateway_used', 50)->nullable();
            $table->text('snap_token')->nullable();
            $table->timestamps();

            $table->index('payment_status', 'idx_order_status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
