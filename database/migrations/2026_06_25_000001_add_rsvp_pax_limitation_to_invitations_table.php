<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('is_rsvp_pax_limited')->default(false)->after('show_rsvp');
            $table->integer('max_global_pax_quota')->nullable()->after('is_rsvp_pax_limited');
            $table->integer('max_pax_per_guest')->default(2)->after('max_global_pax_quota');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['is_rsvp_pax_limited', 'max_global_pax_quota', 'max_pax_per_guest']);
        });
    }
};
