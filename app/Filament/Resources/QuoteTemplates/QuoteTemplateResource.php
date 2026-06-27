<?php

namespace App\Filament\Resources\QuoteTemplates;

use App\Filament\Resources\QuoteTemplates\Pages\CreateQuoteTemplate;
use App\Filament\Resources\QuoteTemplates\Pages\EditQuoteTemplate;
use App\Filament\Resources\QuoteTemplates\Pages\ListQuoteTemplates;
use App\Filament\Resources\QuoteTemplates\Schemas\QuoteTemplateForm;
use App\Filament\Resources\QuoteTemplates\Tables\QuoteTemplatesTable;
use App\Models\QuoteTemplate;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class QuoteTemplateResource extends Resource
{
    protected static ?string $model = QuoteTemplate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $navigationLabel = 'Template Kutipan';

    protected static ?string $pluralLabel = 'Template Kutipan';

    protected static string|\UnitEnum|null $navigationGroup = 'Konten Pengguna';

    protected static ?int $navigationSort = 3;

    protected static ?string $slug = 'quote-templates';

    public static function form(Schema $schema): Schema
    {
        return QuoteTemplateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return QuoteTemplatesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListQuoteTemplates::route('/'),
            'create' => CreateQuoteTemplate::route('/create'),
            'edit' => EditQuoteTemplate::route('/{record}/edit'),
        ];
    }
}
