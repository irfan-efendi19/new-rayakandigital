<?php

namespace App\Filament\Resources\Invitations\Schemas;

use App\Models\Package;
use App\Models\Theme;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class InvitationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('user_id')
                    ->label('Owner (User)')
                    ->relationship('user', 'name')
                    ->options(User::pluck('name', 'id'))
                    ->required()
                    ->disabled(fn (string $operation): bool => $operation === 'edit')
                    ->dehydrated(fn (string $operation): bool => $operation === 'create'),

                TextInput::make('title')
                    ->label('Title')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label('Slug')
                    ->required()
                    ->maxLength(100)
                    ->unique(ignoreRecord: true),

                Select::make('theme')
                    ->label('Theme')
                    ->options(Theme::pluck('name', 'view_path')->mapWithKeys(fn ($name, $path) => [
                        str_replace('themes.', '', $path) => $name
                    ]))
                    ->required(),

                Select::make('pricing_tier_id')
                    ->label('Pricing Package')
                    ->relationship('pricingTier', 'package_name')
                    ->options(Package::pluck('package_name', 'id'))
                    ->nullable(),

                Select::make('tier')
                    ->label('Tier Enum')
                    ->options([
                        'free' => 'Free',
                        'silver' => 'Silver',
                        'gold' => 'Gold',
                        'platinum' => 'Platinum',
                    ])
                    ->required()
                    ->default('free'),

                TextInput::make('bride_name')
                    ->label('Bride Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('bride_nickname')
                    ->label('Bride Nickname')
                    ->maxLength(100),

                TextInput::make('bride_father_name')
                    ->label('Nama Ayah (Wanita)')
                    ->maxLength(255),

                TextInput::make('bride_mother_name')
                    ->label('Nama Ibu (Wanita)')
                    ->maxLength(255),

                TextInput::make('groom_name')
                    ->label('Groom Name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('groom_nickname')
                    ->label('Groom Nickname')
                    ->maxLength(100),

                TextInput::make('groom_father_name')
                    ->label('Nama Ayah (Pria)')
                    ->maxLength(255),

                TextInput::make('groom_mother_name')
                    ->label('Nama Ibu (Pria)')
                    ->maxLength(255),

                DatePicker::make('event_date')
                    ->label('Event Date'),

                TimePicker::make('event_time')
                    ->label('Event Start Time'),

                TimePicker::make('event_time_end')
                    ->label('Event End Time'),

                TextInput::make('venue_name')
                    ->label('Venue Name')
                    ->maxLength(255),

                Textarea::make('venue_address')
                    ->label('Venue Address')
                    ->maxLength(65535),

                TextInput::make('venue_maps_url')
                    ->label('Venue Google Maps URL')
                    ->url()
                    ->maxLength(255),

                Toggle::make('is_active')
                    ->label('Is Active')
                    ->default(true),

                DateTimePicker::make('expires_at')
                    ->label('Expires At'),
            ]);
    }
}
