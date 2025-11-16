<?php

namespace App\Filament\Admin\Resources\Guarantees\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;

class SwipersRelationManager extends RelationManager
{
    protected static string $relationship = 'swipers';

    protected static ?string $title = 'Слайдеры';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            FileUpload::make('image')
                ->label('Изображение')
                ->disk('public')
                ->directory('guarantee/swipers')
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
                    ->disk('public')       // если файлы лежат в storage/app/public
                    ->square(true)  // убираем квадрат
                    ->size(50),
            ])
            ->headerActions([
                CreateAction::make()->label('Добавить слайд'),
            ])
            ->recordActions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->defaultSort('id');
    }
}
