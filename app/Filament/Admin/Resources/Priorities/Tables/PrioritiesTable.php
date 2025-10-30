<?php

namespace App\Filament\Admin\Resources\Priorities\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class PrioritiesTable
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
                TextColumn::make('description_ru')
                    ->searchable(),
                TextColumn::make('description_kk')
                    ->searchable(),
                TextColumn::make('description_en')
                    ->searchable(),
                TextColumn::make('btnText_ru')
                    ->searchable(),
                TextColumn::make('btnText_kk')
                    ->searchable(),
                TextColumn::make('btnText_en')
                    ->searchable(),
                TextColumn::make('main_id')
                    ->numeric()
                    ->sortable(),
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
