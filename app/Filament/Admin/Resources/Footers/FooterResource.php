<?php

namespace App\Filament\Admin\Resources\Footers;

use App\Filament\Admin\Resources\Footers\Pages\CreateFooter;
use App\Filament\Admin\Resources\Footers\Pages\EditFooter;
use App\Filament\Admin\Resources\Footers\Pages\ListFooters;
use App\Filament\Admin\Resources\Footers\Schemas\FooterForm;
use App\Filament\Admin\Resources\Footers\Tables\FootersTable;
use App\Models\Footer;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class FooterResource extends Resource
{
    protected static ?string $model = Footer::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Футер сайта';

    // Рабочая иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentText;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return FooterForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return FootersTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListFooters::route('/'),
            'create' => CreateFooter::route('/create'),
            'edit' => EditFooter::route('/{record}/edit'),
        ];
    }
}
