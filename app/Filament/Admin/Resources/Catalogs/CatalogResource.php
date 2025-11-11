<?php

namespace App\Filament\Admin\Resources\Catalogs;

use App\Filament\Admin\Resources\Catalogs\Pages\CreateCatalog;
use App\Filament\Admin\Resources\Catalogs\Pages\EditCatalog;
use App\Filament\Admin\Resources\Catalogs\Pages\ListCatalogs;
use App\Filament\Admin\Resources\Catalogs\Schemas\CatalogForm;
use App\Filament\Admin\Resources\Catalogs\Tables\CatalogsTable;
use App\Filament\Admin\Resources\Catalogs\RelationManagers\CategoriesRelationManager;
use App\Filament\Admin\Resources\Catalogs\RelationManagers\ItemsRelationManager;
use App\Filament\Admin\Resources\Catalogs\RelationManagers\SeoRelationManager;
use App\Models\Catalog;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class CatalogResource extends Resource
{
    protected static ?string $model = Catalog::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return CatalogForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CatalogsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            CategoriesRelationManager::class,
            SeoRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCatalogs::route('/'),
            'create' => CreateCatalog::route('/create'),
            'edit' => EditCatalog::route('/{record}/edit'),
        ];
    }
}
