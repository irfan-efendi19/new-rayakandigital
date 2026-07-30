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
        Schema::create('wa_settings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('invitation_id')->nullable()->constrained()->cascadeOnDelete();
            $table->string('phone_number', 20)->nullable();
            $table->string('fonnte_token')->nullable();
            $table->enum('status', ['PENDING_VERIFICATION', 'READY_TO_PAIR', 'PAIRING', 'CONNECTED', 'REJECTED'])->default('PENDING_VERIFICATION');
            $table->text('admin_notes')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wa_settings');
    }
};
