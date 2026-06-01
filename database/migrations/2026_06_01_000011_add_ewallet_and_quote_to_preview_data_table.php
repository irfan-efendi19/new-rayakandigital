<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->json('gift_ewallets')->nullable()->after('gift_banks');
            $table->text('quote_content')->nullable()->after('gift_ewallets');
            $table->string('quote_source', 150)->nullable()->after('quote_content');
        });
    }

    public function down(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->dropColumn(['gift_ewallets', 'quote_content', 'quote_source']);
        });
    }
};
