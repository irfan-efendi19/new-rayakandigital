<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            // Kode unik untuk di-generate menjadi QR Code (sementara nullable)
            if (! Schema::hasColumn('guests', 'qr_code_token')) {
                $table->string('qr_code_token')->nullable()->after('id');
            }

            // Status kehadiran tamu
            if (! Schema::hasColumn('guests', 'attendance_status')) {
                $table->enum('attendance_status', ['pending', 'hadir', 'absen'])->default('pending')->after('qr_code_token');
            }
            if (! Schema::hasColumn('guests', 'checked_in_at')) {
                $table->timestamp('checked_in_at')->nullable()->after('attendance_status');
            }
        });

        // Isi token kosong untuk data tamu yang sudah ada sebelum ditambahkan unique constraint
        DB::table('guests')->whereNull('qr_code_token')->orWhere('qr_code_token', '')->chunkById(100, function ($guests) {
            foreach ($guests as $guest) {
                DB::table('guests')
                    ->where('id', $guest->id)
                    ->update(['qr_code_token' => (string) Str::uuid()]);
            }
        });

        // Ubah menjadi non-nullable, tambahkan unique constraint dan index secara aman
        // Dapatkan nama-nama indeks yang ada di tabel 'guests'
        $indexes = Schema::getIndexes('guests');
        $indexNames = collect($indexes)->pluck('name')->toArray();

        Schema::table('guests', function (Blueprint $table) use ($indexNames) {
            $table->string('qr_code_token')->nullable(false)->change();

            if (! in_array('guests_qr_code_token_unique', $indexNames)) {
                $table->unique('qr_code_token');
            }

            if (! in_array('idx_guest_checkin', $indexNames)) {
                $table->index(['qr_code_token', 'attendance_status'], 'idx_guest_checkin');
            }
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $indexes = Schema::getIndexes('guests');
            $indexNames = collect($indexes)->pluck('name')->toArray();

            if (in_array('idx_guest_checkin', $indexNames)) {
                $table->dropIndex('idx_guest_checkin');
            }
            if (in_array('guests_qr_code_token_unique', $indexNames)) {
                $table->dropUnique(['qr_code_token']);
            }

            foreach (['qr_code_token', 'attendance_status', 'checked_in_at'] as $column) {
                if (Schema::hasColumn('guests', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
