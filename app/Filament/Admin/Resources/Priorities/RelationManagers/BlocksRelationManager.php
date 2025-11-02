<?php

namespace App\Filament\Admin\Resources\Priorities\RelationManagers;

use App\Filament\Admin\Resources\Priorities\Schemas\BlocksForm;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';

    // Используем Schema, как в PriorityResource
    public function form(Schema $schema): Schema
    {
        return BlocksForm::configure($schema);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('id')->label('ID')->sortable(),
                TextColumn::make('title_ru')->label('Заголовок (RU)')->searchable(),
                TextColumn::make('title_en')->label('Title (EN)')->searchable(),
                TextColumn::make('title_kk')->label('Тақырып (KK)')->searchable(),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                DeleteBulkAction::make(),
            ]);
    }
}
