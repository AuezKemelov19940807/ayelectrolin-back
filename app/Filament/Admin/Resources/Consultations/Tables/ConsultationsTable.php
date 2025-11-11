<?php

namespace App\Filament\Admin\Resources\Consultations\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ConsultationsTable
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
                TextColumn::make('phone_placeholder_ru')
                    ->searchable(),
                TextColumn::make('phone_placeholder_kk')
                    ->searchable(),
                TextColumn::make('phone_placeholder_en')
                    ->searchable(),
                TextColumn::make('name_placeholder_ru')
                    ->searchable(),
                TextColumn::make('name_placeholder_kk')
                    ->searchable(),
                TextColumn::make('name_placeholder_en')
                    ->searchable(),
                TextColumn::make('message_placeholder_ru')
                    ->searchable(),
                TextColumn::make('message_placeholder_kk')
                    ->searchable(),
                TextColumn::make('message_placeholder_en')
                    ->searchable(),
                TextColumn::make('btn_text_ru')
                    ->searchable(),
                TextColumn::make('btn_text_kk')
                    ->searchable(),
                TextColumn::make('btn_text_en')
                    ->searchable(),
                TextColumn::make('note_text_ru')
                    ->searchable(),
                TextColumn::make('note_text_kk')
                    ->searchable(),
                TextColumn::make('note_text_en')
                    ->searchable(),
                TextColumn::make('contact_info_text_ru')
                    ->searchable(),
                TextColumn::make('contact_info_text_kk')
                    ->searchable(),
                TextColumn::make('contact_info_text_en')
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
