<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->foreignId('guest_category_id')
                ->nullable()
                ->after('invitation_id')
                ->constrained('guest_categories')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropForeign(['guest_category_id']);
            $table->dropColumn('guest_category_id');
        });
    }
};
