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
        Schema::create('invitation_screens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained()->onDelete('cascade');

            // Konfigurasi Utama
            $table->string('selected_theme')->default('minimal-clean'); // ID slug tema
            $table->string('custom_title')->nullable(); // Override Judul Utama (Contoh: "Selamat Datang di Pernikahan Kami")
            $table->boolean('show_wishes_wall')->default(true); // Toggle menampilkan dinding ucapan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invitation_screens');
    }
};
