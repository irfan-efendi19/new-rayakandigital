<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->timestamp('trial_started_at')->nullable()->after('is_active');
            $table->index('expires_at', 'idx_invitation_expiry');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropIndex('idx_invitation_expiry');
            $table->dropColumn('trial_started_at');
        });
    }
};
