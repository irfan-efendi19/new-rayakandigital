<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Penambahan Kolom Pengaturan Utama pada Tabel Cetak Undangan
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('screen_bride_names')->nullable()->after('title'); // Custom Nama Pengantin di Layar Sapa
            $table->string('screen_background_image')->nullable()->after('screen_bride_names'); // Path Foto Background
            $table->integer('screen_overlay_opacity')->default(50)->after('screen_background_image'); // Tingkat Gelap Background (0-100)
        });

        // 2. Tabel Baru untuk Menampung Multi-Foto Galeri Layar Sapa
        Schema::create('screen_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invitation_id')->constrained('invitations')->onDelete('cascade');
            $table->string('image_path'); // Path file foto galeri (.webp hasil kompresi)
            $table->integer('sort_order')->default(0); // Urutan rotasi slide
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('screen_galleries');

        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['screen_bride_names', 'screen_background_image', 'screen_overlay_opacity']);
        });
    }
};
