<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('wa_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('wa_settings', 'invitation_id')) {
                $table->foreignId('invitation_id')->nullable()->after('user_id')->constrained()->cascadeOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('wa_settings', function (Blueprint $table) {
            if (Schema::hasColumn('wa_settings', 'invitation_id')) {
                $table->dropForeign(['invitation_id']);
                $table->dropColumn('invitation_id');
            }
        });
    }
};
