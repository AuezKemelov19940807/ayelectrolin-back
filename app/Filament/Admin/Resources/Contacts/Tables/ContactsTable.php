<?php

namespace App\Filament\Admin\Resources\Contacts\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ayelectrolin_logo')
                    ->searchable(),
                TextColumn::make('ayelectrolin_name_ru')
                    ->searchable(),
                TextColumn::make('ayelectrolin_name_kk')
                    ->searchable(),
                TextColumn::make('ayelectrolin_name_en')
                    ->searchable(),
                TextColumn::make('ayelectrolin_number')
                    ->searchable(),
                TextColumn::make('ayelectrolin_email')
                    ->searchable(),
                TextColumn::make('ayelectrolin_address_ru')
                    ->searchable(),
                TextColumn::make('ayelectrolin_address_kk')
                    ->searchable(),
                TextColumn::make('ayelectrolin_address_en')
                    ->searchable(),
                TextColumn::make('zere_construction_logo')
                    ->searchable(),
                TextColumn::make('zere_construction_name_ru')
                    ->searchable(),
                TextColumn::make('zere_construction_name_kk')
                    ->searchable(),
                TextColumn::make('zere_construction_name_en')
                    ->searchable(),
                TextColumn::make('zere_construction_number')
                    ->searchable(),
                TextColumn::make('zere_construction_email')
                    ->searchable(),
                TextColumn::make('zere_construction_address_ru')
                    ->searchable(),
                TextColumn::make('zere_construction_address_kk')
                    ->searchable(),
                TextColumn::make('zere_construction_address_en')
                    ->searchable(),
                TextColumn::make('latitude')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('longitude')
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
