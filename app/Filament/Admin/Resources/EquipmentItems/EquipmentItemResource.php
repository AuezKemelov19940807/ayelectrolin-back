<?php

namespace App\Filament\Admin\Resources\EquipmentItems;

use App\Filament\Admin\Resources\EquipmentItems\Pages\CreateEquipmentItem;
use App\Filament\Admin\Resources\EquipmentItems\Pages\EditEquipmentItem;
use App\Filament\Admin\Resources\EquipmentItems\Pages\ListEquipmentItems;
use App\Filament\Admin\Resources\EquipmentItems\Schemas\EquipmentItemForm;
use App\Filament\Admin\Resources\EquipmentItems\Tables\EquipmentItemsTable;
use App\Models\EquipmentItem;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EquipmentItemResource extends Resource
{
    protected static ?string $model = EquipmentItem::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Оборудование — элементы';

    // Иконка (корректная константа для твоей версии Filament)
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCube;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return EquipmentItemForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentItemsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipmentItems::route('/'),
            'create' => CreateEquipmentItem::route('/create'),
            'edit' => EditEquipmentItem::route('/{record}/edit'),
        ];
    }
}
