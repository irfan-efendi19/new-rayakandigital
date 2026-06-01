<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->json('gift_banks')->nullable()->after('gift_qris_image');
            $table->json('gift_ewallets')->nullable()->after('gift_banks');
        });

        DB::table('invitations')->orderBy('id')->each(function ($invitation) {
            $banks = [];

            if ($invitation->gift_bank_name || $invitation->gift_bank_account) {
                $banks[] = [
                    'bank_name' => $invitation->gift_bank_name,
                    'account_number' => $invitation->gift_bank_account,
                    'account_holder' => $invitation->gift_bank_holder,
                ];
            }

            DB::table('invitations')
                ->where('id', $invitation->id)
                ->update(['gift_banks' => json_encode($banks)]);

            $ewallets = [];

            if ($invitation->gift_ewallet_name || $invitation->gift_ewallet_number) {
                $ewallets[] = [
                    'wallet_name' => $invitation->gift_ewallet_name,
                    'wallet_number' => $invitation->gift_ewallet_number,
                ];
            }

            DB::table('invitations')
                ->where('id', $invitation->id)
                ->update(['gift_ewallets' => json_encode($ewallets)]);
        });
    }

    public function down(): void
    {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn(['gift_banks', 'gift_ewallets']);
        });
    }
};
