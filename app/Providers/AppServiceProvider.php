<?php

namespace App\Providers;

use App\Models\Invitation;
use App\Models\User;
use App\Policies\InvitationPolicy;
use App\Services\FeatureGateService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(FeatureGateService::class, function () {
            return new FeatureGateService();
        });
    }

    public function boot(): void
    {
        Gate::policy(Invitation::class, InvitationPolicy::class);

        Model::preventLazyLoading(!$this->app->isProduction());

        Gate::before(function (User $user, string $ability, ...$arguments) {
            if ($user->role !== 'admin') {
                return null;
            }

            foreach ($arguments as $arg) {
                if ($arg instanceof Invitation) {
                    if ($arg->user_id === $user->id) {
                        continue;
                    }

                    $adminIds = Cache::remember('admin_user_ids', 3600, function () {
                        return User::where('role', 'admin')->pluck('id')->toArray();
                    });

                    if (in_array($arg->user_id, $adminIds) && !($user->getAttribute('is_super_admin') ?? false)) {
                        return null;
                    }
                }
            }

            return true;
        });
    }
}
