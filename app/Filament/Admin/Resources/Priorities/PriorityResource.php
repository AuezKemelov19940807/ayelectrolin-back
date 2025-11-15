<?php

namespace App\Filament\Admin\Resources\Priorities;

use App\Filament\Admin\Resources\Priorities\Pages\CreatePriority;
use App\Filament\Admin\Resources\Priorities\Pages\EditPriority;
use App\Filament\Admin\Resources\Priorities\Pages\ListPriorities;
use App\Filament\Admin\Resources\Priorities\RelationManagers\BlocksRelationManager;
use App\Filament\Admin\Resources\Priorities\Schemas\PriorityForm;
use App\Filament\Admin\Resources\Priorities\Tables\PrioritiesTable;
use App\Models\Priority;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class PriorityResource extends Resource
{
    protected static ?string $model = Priority::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Наши приоритеты';

    // Иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedStar;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return PriorityForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PrioritiesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            BlocksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPriorities::route('/'),
            'create' => CreatePriority::route('/create'),
            'edit' => EditPriority::route('/{record}/edit'),
        ];
    }
}
