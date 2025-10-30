<?php

namespace App\Filament\Admin\Resources\Brands\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Изображения';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Изображение')
                ->disk('public')
                ->directory('brands/items')
                ->image()
                ->required()
                ->columnSpanFull(),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->columns([
                ImageColumn::make('image')
                    ->label('Изображение')
                    ->square(),
            ])
            ->headerActions([
                CreateAction::make()->label('Добавить изображение'),
            ])
            ->recordActions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->defaultSort('id');
    }
}
