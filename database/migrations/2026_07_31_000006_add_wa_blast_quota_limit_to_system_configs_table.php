<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_configs', function (Blueprint $table) {
            $table->unsignedInteger('wa_blast_quota_limit')->nullable()->after('demo_grace_period_days');
        });

        Schema::table('invitations', function (Blueprint $table) {
            if (Schema::hasColumn('invitations', 'wa_quota_limit')) {
                $table->dropColumn('wa_quota_limit');
            }
        });
    }

    public function down(): void
    {
        Schema::table('system_configs', function (Blueprint $table) {
            if (Schema::hasColumn('system_configs', 'wa_blast_quota_limit')) {
                $table->dropColumn('wa_blast_quota_limit');
            }
        });

        Schema::table('invitations', function (Blueprint $table) {
            if (! Schema::hasColumn('invitations', 'wa_quota_limit')) {
                $table->unsignedInteger('wa_quota_limit')->nullable()->after('custom_music');
            }
        });
    }
};
