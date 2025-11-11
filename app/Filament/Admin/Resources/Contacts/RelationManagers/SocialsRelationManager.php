<?php

namespace App\Filament\Admin\Resources\Contacts\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SocialsRelationManager extends RelationManager
{
    protected static string $relationship = 'socials';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('platform')
                    ->required(),
                TextInput::make('link')
                    ->required(),
                FileUpload::make('icon') // теперь FileUpload для иконки
                    ->label('Icon')
                    ->directory('social-icons') // папка для хранения
                    ->image() // только изображение
                    ->disk('public')
                    ->required(false),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('platform')
            ->columns([
                TextColumn::make('platform')
                    ->searchable(),
                TextColumn::make('link')
                    ->searchable(),
                TextColumn::make('icon') // выводим путь к файлу
                    ->label('Icon')
                    ->formatStateUsing(fn ($state) => $state ? '<img src="'.asset('storage/'.$state).'" class="h-6 w-6" />' : '-')
                    ->html()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            ->headerActions([
                CreateAction::make(),
                AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
