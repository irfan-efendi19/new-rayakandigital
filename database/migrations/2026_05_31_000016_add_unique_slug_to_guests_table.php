<?php

use App\Models\Guest;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $this->resolveExistingDuplicates();

        Schema::table('guests', function (Blueprint $table) {
            $table->string('slug', 150)->nullable(false)->change();

            // Foreign key on invitation_id requires an index; add a dedicated
            // index first so we can safely drop the old composite index.
            $table->index('invitation_id', 'guests_invitation_id_index');

            $table->dropIndex(['invitation_id', 'slug']);

            $table->unique(['invitation_id', 'slug'], 'idx_unique_guest_per_invitation');
        });
    }

    protected function resolveExistingDuplicates(): void
    {
        Guest::whereNull('slug')->each(function (Guest $guest) {
            $slug = Str::slug($guest->name);
            $guest->slug = $slug;
            $guest->saveQuietly();
        });

        $duplicates = Guest::selectRaw('invitation_id, slug, COUNT(*) as cnt')
            ->groupBy('invitation_id', 'slug')
            ->having('cnt', '>', 1)
            ->get();

        foreach ($duplicates as $dup) {
            $counter = 1;
            $guests = Guest::where('invitation_id', $dup->invitation_id)
                ->where('slug', $dup->slug)
                ->orderBy('id')
                ->get();

            foreach ($guests as $guest) {
                if ($counter === 1) {
                    $counter++;
                    continue;
                }

                $newSlug = $dup->slug . '-' . $counter;
                $guest->slug = $newSlug;
                $guest->saveQuietly();
                $counter++;
            }
        }
    }

    public function down(): void
    {
        Schema::table('guests', function (Blueprint $table) {
            $table->dropIndex('idx_unique_guest_per_invitation');

            $table->index(['invitation_id', 'slug']);

            $table->dropIndex('guests_invitation_id_index');

            $table->string('slug', 255)->nullable()->change();
        });
    }
};
