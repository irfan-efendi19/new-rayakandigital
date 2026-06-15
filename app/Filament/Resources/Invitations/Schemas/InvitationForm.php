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
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class InvitationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('General Information')
                    ->description('Primary details and system settings of the invitation.')
                    ->schema([
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
                                str_replace('themes.', '', $path) => $name,
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

                        Toggle::make('is_active')
                            ->label('Is Active')
                            ->default(true),

                        DateTimePicker::make('expires_at')
                            ->label('Expires At'),
                    ])->columns(2),

                Section::make('Bride (Mempelai Wanita) Details')
                    ->description('Information about the bride and her parents.')
                    ->schema([
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
                    ])->columns(2),

                Section::make('Groom (Mempelai Pria) Details')
                    ->description('Information about the groom and his parents.')
                    ->schema([
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
                    ])->columns(2),

                Section::make('Event & Venue Details')
                    ->description('Configure schedule and location for the main celebration.')
                    ->schema([
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
                            ->maxLength(65535)
                            ->columnSpanFull(),

                        TextInput::make('venue_maps_url')
                            ->label('Venue Google Maps URL')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])->columns(3),

                Section::make('Layar Sapa Settings')
                    ->description('Kustomisasi tampilan Layar Sapa (Welcome Screen) proyektor.')
                    ->schema([
                        TextInput::make('screen_bride_names')
                            ->label('Nama Pajangan Pengantin')
                            ->placeholder('Contoh: Romeo & Juliet')
                            ->maxLength(255),

                        TextInput::make('screen_overlay_opacity')
                            ->label('Tingkat Gelap Overlay (0-100)')
                            ->numeric()
                            ->default(50)
                            ->minValue(0)
                            ->maxValue(100),
                    ])->columns(2),
            ]);
    }
}
