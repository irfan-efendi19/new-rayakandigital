<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->boolean('wa_template_enabled')->default(false)->after('is_active');
            $table->text('wa_message_template')->nullable()->after('wa_template_enabled');
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['wa_template_enabled', 'wa_message_template']);
        });
    }
};
