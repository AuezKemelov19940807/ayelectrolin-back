<?php

namespace App\Filament\Admin\Resources\CatalogItems;

use App\Filament\Admin\Resources\CatalogItems\Pages\CreateCatalogItem;
use App\Filament\Admin\Resources\CatalogItems\Pages\EditCatalogItem;
use App\Filament\Admin\Resources\CatalogItems\Pages\ListCatalogItems;
use App\Filament\Admin\Resources\CatalogItems\RelationManagers\SeoRelationManager;
use App\Filament\Admin\Resources\CatalogItems\Schemas\CatalogItemForm;
use App\Filament\Admin\Resources\CatalogItems\Tables\CatalogItemsTable;
use App\Models\CatalogItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatalogItemResource extends Resource
{
    protected static ?string $model = CatalogItem::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Каталог товаров';

    // Новая иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CatalogItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatalogItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            SeoRelationManager::class,
        ];
    }

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatalogItems::route('/'),
            'create' => CreateCatalogItem::route('/create'),
            'edit' => EditCatalogItem::route('/{record}/edit'),
        ];
    }
}
