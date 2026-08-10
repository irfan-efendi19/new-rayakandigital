<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('wedding_rundowns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->time('time_start');
            $table->time('time_end')->nullable();
            $table->string('activity_name');
            $table->string('person_in_charge', 100)->nullable();
            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index(['user_id', 'time_start']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('wedding_rundowns');
    }
};
