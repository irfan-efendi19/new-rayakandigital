<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            Schema::table('invitations', function (Blueprint $table) {
                $table->string('theme')->default('elegant')->change();
            });

            return;
        }

        DB::statement("ALTER TABLE invitations MODIFY COLUMN theme VARCHAR(255) NOT NULL DEFAULT 'elegant'");
    }

    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            // SQLite doesn't natively support changing back to custom enum via change(), so we can skip
            return;
        }

        DB::statement("ALTER TABLE invitations MODIFY COLUMN theme ENUM('elegant', 'modern', 'garden') NOT NULL DEFAULT 'elegant'");
    }
};
