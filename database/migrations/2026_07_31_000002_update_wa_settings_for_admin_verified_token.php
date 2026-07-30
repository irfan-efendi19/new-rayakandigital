<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wa_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('wa_settings', 'admin_notes')) {
                $table->text('admin_notes')->nullable()->after('status');
            }
            if (! Schema::hasColumn('wa_settings', 'verified_at')) {
                $table->timestamp('verified_at')->nullable()->after('admin_notes');
            }
        });

        // Driver-specific column modification
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE wa_settings MODIFY COLUMN status ENUM('PENDING_VERIFICATION','READY_TO_PAIR','PAIRING','CONNECTED','REJECTED') DEFAULT 'PENDING_VERIFICATION'");
            DB::statement("UPDATE wa_settings SET status = 'PENDING_VERIFICATION' WHERE status NOT IN ('PENDING_VERIFICATION','READY_TO_PAIR','PAIRING','CONNECTED','REJECTED')");
        }
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE wa_settings MODIFY COLUMN status ENUM('DISCONNECTED','PAIRING','CONNECTED') DEFAULT 'DISCONNECTED'");
        }

        Schema::table('wa_settings', function (Blueprint $table) {
            $colsToDrop = [];
            if (Schema::hasColumn('wa_settings', 'admin_notes')) {
                $colsToDrop[] = 'admin_notes';
            }
            if (Schema::hasColumn('wa_settings', 'verified_at')) {
                $colsToDrop[] = 'verified_at';
            }
            if (! empty($colsToDrop)) {
                $table->dropColumn($colsToDrop);
            }
        });
    }
};
