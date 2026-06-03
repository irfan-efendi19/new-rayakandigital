<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('bride_father_name')->nullable()->after('bride_parents');
            $table->string('bride_mother_name')->nullable()->after('bride_father_name');
            $table->string('groom_father_name')->nullable()->after('groom_parents');
            $table->string('groom_mother_name')->nullable()->after('groom_father_name');
        });

        Schema::table('preview_data', function (Blueprint $table) {
            $table->string('bride_father_name')->nullable()->after('bride_parents');
            $table->string('bride_mother_name')->nullable()->after('bride_father_name');
            $table->string('groom_father_name')->nullable()->after('groom_parents');
            $table->string('groom_mother_name')->nullable()->after('groom_father_name');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['bride_father_name', 'bride_mother_name', 'groom_father_name', 'groom_mother_name']);
        });

        Schema::table('preview_data', function (Blueprint $table) {
            $table->dropColumn(['bride_father_name', 'bride_mother_name', 'groom_father_name', 'groom_mother_name']);
        });
    }
};
