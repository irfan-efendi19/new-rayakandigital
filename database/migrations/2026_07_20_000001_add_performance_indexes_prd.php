<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            // PRD 2.1.3: indeks kolom pencarian publik & relasi kunci asing.
            // `slug` (unique) & `user_id` sudah memiliki indeks sejak pembuatan tabel.
            // `is_active` digunakan dalam filter berat pada render undangan publik & daftar.
            if (! Schema::hasIndex('invitations', 'invitations_is_active_index')) {
                $table->boolean('is_active')->index()->change();
            }
        });

        Schema::table('wishes', function (Blueprint $table) {
            // PRD merujuk tabel `comments` (Wishes Wall); di kodebasis tabelnya adalah `wishes`.
            // `invitation_id` sudah memiliki indeks. Tambahkan indeks `is_hidden` yang dipakai
            // pada kueri Layar Sapa: where('is_hidden', false).
            if (! Schema::hasIndex('wishes', 'wishes_is_hidden_index')) {
                $table->boolean('is_hidden')->index()->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasIndex('invitations', 'invitations_is_active_index')) {
                $table->dropIndex('invitations_is_active_index');
            }
        });

        Schema::table('wishes', function (Blueprint $table) {
            if (Schema::hasIndex('wishes', 'wishes_is_hidden_index')) {
                $table->dropIndex('wishes_is_hidden_index');
            }
        });
    }
};
