<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('invitations') && !Schema::hasColumn('invitations', 'pricing_tier_id')) {
            Schema::table('invitations', function (Blueprint $table) {
                $table->foreignId('pricing_tier_id')
                    ->nullable()
                    ->after('user_id')
                    ->constrained('packages')
                    ->onDelete('set null');
            });
        }

        if (Schema::hasColumn('users', 'pricing_tier_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropForeign(['pricing_tier_id']);
                $table->dropColumn('pricing_tier_id');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'pricing_tier_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->foreignId('pricing_tier_id')->nullable()->constrained('packages');
            });
        }
    }
};
