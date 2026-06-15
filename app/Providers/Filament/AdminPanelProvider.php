<?php

namespace App\Providers\Filament;

use App\Filament\Widgets\InvitationsChart;
use App\Filament\Widgets\OrdersByStatusChart;
use App\Filament\Widgets\PendingOrders;
use App\Filament\Widgets\RevenueChart;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\SubscriptionTiersChart;
use App\Filament\Widgets\UsersChart;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use App\Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->brandName('Rayakan Digital')
            ->font('Plus Jakarta Sans')
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => [
                    50 => '#FFF4EB',
                    100 => '#FFE4CC',
                    200 => '#FFD0A3',
                    300 => '#FFB56B',
                    400 => '#FF9733',
                    500 => '#FF7A00',
                    600 => '#D96500',
                    700 => '#B35200',
                    800 => '#8C4000',
                    900 => '#663000',
                ],
                'gray' => Color::Zinc,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                StatsOverview::class,
                RevenueChart::class,
                InvitationsChart::class,
                UsersChart::class,
                OrdersByStatusChart::class,
                SubscriptionTiersChart::class,
                PendingOrders::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
