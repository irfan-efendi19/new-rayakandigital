<?php

namespace App\Console\Commands;

use App\Models\Invitation;
use App\Models\SystemConfig;
use Illuminate\Console\Command;

class CleanupExpiredInvitations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'invitations:cleanup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up expired invitations after grace period has passed';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $graceDays = SystemConfig::first()?->demo_grace_period_days ?? 30;
        $cutoffDate = now()->subDays($graceDays);

        $expiredInvitations = Invitation::whereNotNull('expires_at')
            ->where('expires_at', '<=', $cutoffDate)
            ->get();

        $count = $expiredInvitations->count();

        if ($count === 0) {
            $this->info('No expired invitations to clean up.');
            return Command::SUCCESS;
        }

        $this->info("Found {$count} invitation(s) past grace period. Cleaning up...");

        foreach ($expiredInvitations as $invitation) {
            // Delete invitation (this cascade deletes guests, rsvps, wishes if migration configured it)
            // Wait, invitation model doesn't automatically delete files from disk if not hooked, 
            // but standard Eloquent delete is sufficient as per the schema setup.
            $invitation->delete();
        }

        $this->info("Successfully cleaned up {$count} invitation(s).");

        return Command::SUCCESS;
    }
}
