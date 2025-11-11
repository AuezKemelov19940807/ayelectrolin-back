<?php

namespace App\Filament\Admin\Resources\Banners\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title_en')
                    ->searchable(),
                TextColumn::make('title_ru')
                    ->searchable(),
                TextColumn::make('title_kk')
                    ->searchable(),
                TextColumn::make('subtitle_en')
                    ->searchable(),
                TextColumn::make('subtitle_ru')
                    ->searchable(),
                TextColumn::make('subtitle_kk')
                    ->searchable(),
                TextColumn::make('btnText_en')
                    ->searchable(),
                TextColumn::make('btnText_ru')
                    ->searchable(),
                TextColumn::make('btnText_kk')
                    ->searchable(),
                ImageColumn::make('image'),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('main_id')
                    ->numeric()
                    ->sortable(),
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
