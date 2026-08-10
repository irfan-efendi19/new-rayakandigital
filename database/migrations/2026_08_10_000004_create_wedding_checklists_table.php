<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('category_code', 50);
            $table->string('category_name', 100);
            $table->string('title', 255);
            $table->text('description')->nullable();
            $table->boolean('is_completed')->default(false);
            $table->boolean('is_preset')->default(true);
            $table->timestamps();

            $table->index(['invitation_id', 'category_code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_checklists');
    }
};
