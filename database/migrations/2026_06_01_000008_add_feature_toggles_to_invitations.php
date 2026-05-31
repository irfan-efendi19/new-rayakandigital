<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('show_qr_checkin')->default(true)->after('expires_at');
            $table->boolean('show_comments')->default(true)->after('show_qr_checkin');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['show_qr_checkin', 'show_comments']);
        });
    }
};
