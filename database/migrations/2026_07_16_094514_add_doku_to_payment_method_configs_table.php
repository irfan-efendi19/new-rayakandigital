<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        // Step 1: Change the enum to include 'doku' option
        // MySQL requires modifying the column definition
        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payment_method_configs MODIFY COLUMN active_method ENUM('manual_bank', 'midtrans', 'doku') NOT NULL DEFAULT 'manual_bank'");
        } else {
            Schema::table('payment_method_configs', function (Blueprint $table) {
                $table->string('active_method')->change();
            });
        }

        // Step 2: Add DOKU credential columns
        Schema::table('payment_method_configs', function (Blueprint $table) {
            $table->text('doku_client_id')->nullable()->after('midtrans_environment');
            $table->text('doku_secret_key')->nullable()->after('doku_client_id');
            $table->text('doku_private_key')->nullable()->after('doku_secret_key');
            $table->enum('doku_environment', ['sandbox', 'production'])->default('sandbox')->after('doku_private_key');
        });
    }

    public function down(): void
    {
        Schema::table('payment_method_configs', function (Blueprint $table) {
            $table->dropColumn([
                'doku_client_id',
                'doku_secret_key',
                'doku_private_key',
                'doku_environment',
            ]);
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement("ALTER TABLE payment_method_configs MODIFY COLUMN active_method ENUM('manual_bank', 'midtrans') NOT NULL DEFAULT 'manual_bank'");
        }
    }
};
