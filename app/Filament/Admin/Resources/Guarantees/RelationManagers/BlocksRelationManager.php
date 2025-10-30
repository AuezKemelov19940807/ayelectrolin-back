<?php

namespace App\Filament\Admin\Resources\Guarantees\RelationManagers;

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

class BlocksRelationManager extends RelationManager
{
    protected static string $relationship = 'blocks';

    protected static ?string $title = 'Блоки';

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
                        $lang = $record?->title_ru ? 'ru' :
                                  ($record?->title_en ? 'en' : 'kk');
                        $component->state($lang);
                    }
                })
                ->columnSpan('full'),

            TextInput::make('title_ru')
                ->label('Заголовок (RU)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'ru')
                ->columnSpanFull(),

            TextInput::make('title_en')
                ->label('Title (EN)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'en')
                ->columnSpanFull(),

            TextInput::make('title_kk')
                ->label('Тақырып (KK)')
                ->required()
                ->visible(fn ($get) => $get('language') === 'kk')
                ->columnSpanFull(),

            Textarea::make('description_ru')
                ->label('Описание (RU)')
                ->rows(3)
                ->visible(fn ($get) => $get('language') === 'ru'),

            Textarea::make('description_en')
                ->label('Description (EN)')
                ->rows(3)
                ->visible(fn ($get) => $get('language') === 'en'),

            Textarea::make('description_kk')
                ->label('Сипаттама (KK)')
                ->rows(3)
                ->visible(fn ($get) => $get('language') === 'kk'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('title_ru')->label('Заголовок (RU)')->searchable(),
                TextColumn::make('title_en')->label('Title (EN)')->searchable(),
                TextColumn::make('title_kk')->label('Тақырып (KK)')->searchable(),
            ])
            ->headerActions([
                CreateAction::make()->label('Добавить блок'),
            ])
            ->recordActions([
                EditAction::make()->label('Редактировать'),
                DeleteAction::make()->label('Удалить'),
            ])
            ->defaultSort('id');
    }
}
