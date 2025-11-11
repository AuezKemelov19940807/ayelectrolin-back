<?php

namespace App\Filament\Admin\Resources\Reviews\RelationManagers;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Отзывы';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            ToggleButtons::make('language')
                ->options([
                    'ru' => 'RU',
                    'kk' => 'KK',
                    'en' => 'EN',
                ])
                ->inline()
                ->reactive()
                ->afterStateHydrated(function ($component, $state, $record) {
                    if (! $state) {
                        $lang = $record?->fullname_ru ? 'ru' :
                                ($record?->fullname_en ? 'en' : 'kk');
                        $component->state($lang);
                    }
                })
                ->columnSpan('full'),

            TextInput::make('fullname_ru')
                ->label('ФИО (RU)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'ru')
                ->columnSpanFull(),

            TextInput::make('fullname_en')
                ->label('Full Name (EN)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'en')
                ->columnSpanFull(),

            TextInput::make('fullname_kk')
                ->label('Аты-жөні (KK)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'kk')
                ->columnSpanFull(),

            Textarea::make('description_ru')
                ->label('Отзыв (RU)')
                ->rows(4)
                ->columnSpanFull()
                ->visible(fn ($get) => $get('language') === 'ru'),

            Textarea::make('description_en')
                ->label('Review (EN)')
                ->rows(4)
                ->columnSpanFull()
                ->visible(fn ($get) => $get('language') === 'en'),

            Textarea::make('description_kk')
                ->label('Пікір (KK)')
                ->rows(4)
                ->columnSpanFull()
                ->visible(fn ($get) => $get('language') === 'kk'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('fullname_ru')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('fullname_ru')->label('ФИО (RU)')->searchable(),
                TextColumn::make('fullname_en')->label('Full Name (EN)')->searchable(),
                TextColumn::make('fullname_kk')->label('Аты-жөні (KK)')->searchable(),
                TextColumn::make('description_ru')->label('Отзыв (RU)')->limit(50),
                TextColumn::make('description_en')->label('Review (EN)')->limit(50),
                TextColumn::make('description_kk')->label('Пікір (KK)')->limit(50),
            ])
            ->headerActions([
                CreateAction::make()->label('Добавить отзыв'),
            ])
            ->recordActions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->defaultSort('id');
    }
}
