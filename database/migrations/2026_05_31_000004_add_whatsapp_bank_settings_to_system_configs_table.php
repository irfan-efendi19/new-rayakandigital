<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('system_configs', function (Blueprint $table) {
            $columns = ['whatsapp_number', 'bank_name', 'bank_account_number', 'bank_account_holder'];
            $existing = array_filter($columns, fn ($col) => Schema::hasColumn('system_configs', $col));

            if (count($existing) === 0) {
                $table->string('whatsapp_number', 20)->nullable()->after('demo_grace_period_days');
                $table->string('bank_name', 100)->nullable()->after('whatsapp_number');
                $table->string('bank_account_number', 50)->nullable()->after('bank_name');
                $table->string('bank_account_holder', 100)->nullable()->after('bank_account_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('system_configs', function (Blueprint $table) {
            $table->dropColumn(['whatsapp_number', 'bank_name', 'bank_account_number', 'bank_account_holder']);
        });
    }
};
