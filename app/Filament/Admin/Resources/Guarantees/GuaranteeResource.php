<?php

namespace App\Filament\Admin\Resources\Guarantees;

use App\Filament\Admin\Resources\Guarantees\Pages\CreateGuarantee;
use App\Filament\Admin\Resources\Guarantees\Pages\EditGuarantee;
use App\Filament\Admin\Resources\Guarantees\Pages\ListGuarantees;
use App\Filament\Admin\Resources\Guarantees\RelationManagers\BlocksRelationManager;
use App\Filament\Admin\Resources\Guarantees\RelationManagers\SwipersRelationManager;
use App\Filament\Admin\Resources\Guarantees\Schemas\GuaranteeForm;
use App\Filament\Admin\Resources\Guarantees\Tables\GuaranteesTable;
use App\Models\Guarantee;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class GuaranteeResource extends Resource
{
    protected static ?string $model = Guarantee::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Гарантии';

    protected static ?int $navigationSort = 6;

    // Иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return GuaranteeForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return GuaranteesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BlocksRelationManager::class,
            SwipersRelationManager::class,
        ];
    }

    public static function getBreadcrumb(): string
    {
        return 'Гарантии';
    }

    public static function getPluralLabel(): string
    {
        return 'Гарантия блока';
    }

    public static function getLabel(): string
    {
        return 'Гарантия блока';
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGuarantees::route('/'),
            'create' => CreateGuarantee::route('/create'),
            'edit' => EditGuarantee::route('/{record}/edit'),
        ];
    }
}
