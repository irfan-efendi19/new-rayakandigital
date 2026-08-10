<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_planner_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->enum('category', [
                'CALENDAR',
                'CHECKLIST',
                'ENGAGEMENT',
                'PRE_WEDDING',
                'SESERAHAN',
                'ADMINISTRATION',
                'BUDGET',
                'VENDOR',
            ]);
            $table->string('title');
            $table->text('description')->nullable();

            $table->decimal('estimated_cost', 12, 2)->default(0);
            $table->decimal('actual_cost', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->string('vendor_contact', 100)->nullable();

            $table->dateTime('event_date')->nullable();
            $table->enum('status', ['PENDING', 'IN_PROGRESS', 'COMPLETED', 'CANCELLED'])->default('PENDING');

            $table->timestamps();

            $table->index(['user_id', 'category']);
            $table->index(['user_id', 'event_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_planner_items');
    }
};
