<?php

namespace App\Filament\Pages;

use Filament\Actions\Action;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\AccountWidget;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    protected static ?string $title = 'Dashboard';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?int $navigationSort = -2;

    public static function getNavigationIcon(): string|\BackedEnum|Htmlable|null
    {
        return Heroicon::OutlinedHome;
    }

    public function getColumns(): int|array
    {
        return [
            'default' => 1,
            'sm' => 2,
            'md' => 6,
            'xl' => 12,
        ];
    }

    public function getHeaderWidgets(): array
    {
        return [
            AccountWidget::class,
        ];
    }

    public function getHeaderActions(): array
    {
        return [
            Action::make('refresh')
                ->label('Refresh Data')
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->action(fn () => $this->dispatch('$refresh')),
        ];
    }
}
