<?php

namespace App\Filament\Admin\Resources\Equipment;

use App\Filament\Admin\Resources\Equipment\Pages\CreateEquipment;
use App\Filament\Admin\Resources\Equipment\Pages\EditEquipment;
use App\Filament\Admin\Resources\Equipment\Pages\ListEquipment;
use App\Filament\Admin\Resources\Equipment\Schemas\EquipmentForm;
use App\Filament\Admin\Resources\Equipment\Tables\EquipmentTable;
use App\Models\Equipment;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class EquipmentResource extends Resource
{
    protected static ?string $model = Equipment::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Оборудование';

    // Иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCpuChip;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return EquipmentForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return EquipmentTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEquipment::route('/'),
            'create' => CreateEquipment::route('/create'),
            'edit' => EditEquipment::route('/{record}/edit'),
        ];
    }
}
