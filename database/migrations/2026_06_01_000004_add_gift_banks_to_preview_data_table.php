<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->json('gift_banks')->nullable()->after('gift_bank_holder');
        });

        DB::table('preview_data')->orderBy('id')->each(function ($row) {
            $banks = [];

            if ($row->gift_bank_name || $row->gift_bank_account) {
                $banks[] = [
                    'bank_name' => $row->gift_bank_name,
                    'account_number' => $row->gift_bank_account,
                    'account_holder' => $row->gift_bank_holder,
                ];
            }

            DB::table('preview_data')
                ->where('id', $row->id)
                ->update(['gift_banks' => json_encode($banks)]);
        });
    }

    public function down(): void
    {
        Schema::table('preview_data', function (Blueprint $table) {
            $table->dropColumn('gift_banks');
        });
    }
};
