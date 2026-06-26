<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->enum('bride_groom_order', ['male_first', 'female_first'])->default('male_first');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('bride_groom_order');
        });
    }
};
