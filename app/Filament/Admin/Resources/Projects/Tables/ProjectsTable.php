<?php

namespace App\Filament\Admin\Resources\Projects\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ProjectsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_ru')
                    ->searchable(),
                TextColumn::make('title_kk')
                    ->searchable(),
                TextColumn::make('title_en')
                    ->searchable(),
                TextColumn::make('subtitle_ru')
                    ->searchable(),
                TextColumn::make('subtitle_kk')
                    ->searchable(),
                TextColumn::make('subtitle_en')
                    ->searchable(),
                ImageColumn::make('image_1'),
                ImageColumn::make('image_2'),
                ImageColumn::make('image_3'),
                ImageColumn::make('image_4'),
                ImageColumn::make('image_5'),
                ImageColumn::make('image_6'),
                ImageColumn::make('image_7'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
