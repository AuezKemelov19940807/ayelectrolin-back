<?php

namespace App\Filament\Admin\Resources\Seos;

use App\Filament\Admin\Resources\Seos\Pages\CreateSeo;
use App\Filament\Admin\Resources\Seos\Pages\EditSeo;
use App\Filament\Admin\Resources\Seos\Pages\ListSeos;
use App\Filament\Admin\Resources\Seos\Schemas\SeoForm;
use App\Filament\Admin\Resources\Seos\Tables\SeosTable;
use App\Models\Seo;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class SeoResource extends Resource
{
    protected static ?string $model = Seo::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'SEO настройки';

    // Иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAlt;

    protected static ?string $recordTitleAttribute = 'title';

    protected static ?int $navigationSort = 16;

    public static function form(Schema $schema): Schema
    {
        return SeoForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return SeosTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getBreadcrumb(): string
    {
        return 'Блок SEO настройки';
    }

    public static function getPluralLabel(): string
    {
        return 'SEO настройки';
    }

    public static function getLabel(): string
    {
        return 'SEO настройки';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListSeos::route('/'),
            'create' => CreateSeo::route('/create'),
            'edit' => EditSeo::route('/{record}/edit'),
        ];
    }
}
