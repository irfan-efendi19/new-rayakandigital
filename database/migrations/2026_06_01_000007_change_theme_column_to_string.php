<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE invitations MODIFY COLUMN theme VARCHAR(255) NOT NULL DEFAULT 'elegant'");
    }

    public function down(): void
    {
        DB::statement("ALTER TABLE invitations MODIFY COLUMN theme ENUM('elegant', 'modern', 'garden') NOT NULL DEFAULT 'elegant'");
    }
};
