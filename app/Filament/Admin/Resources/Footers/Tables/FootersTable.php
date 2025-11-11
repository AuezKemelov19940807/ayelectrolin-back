<?php

namespace App\Filament\Admin\Resources\Footers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FootersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('copy_ru')
                    ->searchable(),
                TextColumn::make('copy_kk')
                    ->searchable(),
                TextColumn::make('copy_en')
                    ->searchable(),
                TextColumn::make('privacy_policy_text_ru')
                    ->searchable(),
                TextColumn::make('privacy_policy_text_kk')
                    ->searchable(),
                TextColumn::make('privacy_policy_text_en')
                    ->searchable(),
                TextColumn::make('privacy_policy_link_ru')
                    ->searchable(),
                TextColumn::make('privacy_policy_link_kk')
                    ->searchable(),
                TextColumn::make('privacy_policy_link_en')
                    ->searchable(),
                TextColumn::make('cookie_policy_text_ru')
                    ->searchable(),
                TextColumn::make('cookie_policy_text_kk')
                    ->searchable(),
                TextColumn::make('cookie_policy_text_en')
                    ->searchable(),
                TextColumn::make('cookie_policy_link_ru')
                    ->searchable(),
                TextColumn::make('cookie_policy_link_kk')
                    ->searchable(),
                TextColumn::make('cookie_policy_link_en')
                    ->searchable(),
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
