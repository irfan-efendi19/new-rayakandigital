<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitation_stories', function (Blueprint $table) {
            $table->string('story_title')->nullable()->after('story_date');
        });
    }

    public function down(): void
    {
        Schema::table('invitation_stories', function (Blueprint $table) {
            $table->dropColumn('story_title');
        });
    }
};
