<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->foreignId('pricing_tier_id')
                ->nullable()
                ->after('is_active')
                ->constrained('packages')
                ->onDelete('set null');
        });

        DB::statement('UPDATE invitations SET pricing_tier_id = (SELECT id FROM packages WHERE packages.package_code = invitations.tier LIMIT 1)');
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropForeign(['pricing_tier_id']);
            $table->dropColumn('pricing_tier_id');
        });
    }
};
