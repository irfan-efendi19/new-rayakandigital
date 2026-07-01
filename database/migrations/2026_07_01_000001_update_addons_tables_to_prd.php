<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('addons', function (Blueprint $table) {
            $table->renameColumn('feature_name', 'name');
            $table->renameColumn('feature_key', 'slug');
            $table->renameColumn('is_active', 'is_available');

            $table->text('description')->nullable()->after('price');
            $table->string('icon_identifier')->nullable()->default('heroicon-o-puzzle-piece')->after('description');
        });

        Schema::table('addon_invitation', function (Blueprint $table) {
            $table->decimal('purchased_price', 10, 2)->after('addon_id');
            $table->boolean('status_active')->default(false)->after('purchased_price');
            $table->timestamp('activated_at')->nullable()->after('status_active');
        });
    }

    public function down(): void
    {
        Schema::table('addon_invitation', function (Blueprint $table) {
            $table->dropColumn(['purchased_price', 'status_active', 'activated_at']);
        });

        Schema::table('addons', function (Blueprint $table) {
            $table->renameColumn('name', 'feature_name');
            $table->renameColumn('slug', 'feature_key');
            $table->renameColumn('is_available', 'is_active');

            $table->dropColumn(['description', 'icon_identifier']);
        });
    }
};
