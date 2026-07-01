<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addon_transactions', function (Blueprint $table) {
            $table->id();
            $table->string('reference_order_id')->unique();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->foreignId('addon_id')->constrained('addons')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('payment_status')->default('pending');
            $table->string('snap_token')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addon_transactions');
    }
};
