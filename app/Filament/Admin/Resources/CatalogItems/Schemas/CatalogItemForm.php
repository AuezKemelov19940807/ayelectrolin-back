<?php

namespace App\Filament\Admin\Resources\CatalogItems\Schemas;

use App\Models\Category;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class CatalogItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([

            Select::make('category_id')
                ->label('Категория')
                ->options(fn () => Category::pluck('category_ru', 'id')->toArray())
                ->searchable()
                ->preload()
                ->required(),

            ToggleButtons::make('language')
                ->label('Язык')
                ->options([
                    'ru' => 'RU',
                    'kk' => 'KK',
                    'en' => 'EN',
                ])
                ->inline()
                ->reactive()
                ->default('ru')
                ->afterStateHydrated(function ($component, $state, $record) {
                    if (! $state) {
                        $lang = $record?->title_ru ? 'ru' :
                                ($record?->title_en ? 'en' : 'kk');
                        $component->state($lang);
                    }
                })
                ->columnSpanFull(),

            TextInput::make('title_ru')
                ->label('Название (RU)')
                ->required(fn ($get) => $get('language') === 'ru')
                ->visible(fn ($get) => $get('language') === 'ru')
                ->reactive()
                ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

            TextInput::make('title_kk')
                ->label('Название (KK)')
                ->visible(fn ($get) => $get('language') === 'kk')
                ->reactive(),

            TextInput::make('title_en')
                ->label('Название (EN)')
                ->visible(fn ($get) => $get('language') === 'en')
                ->reactive(),

            Textarea::make('description_ru')->label('Описание (RU)')->visible(fn ($get) => $get('language') === 'ru')->columnSpanFull(),
            Textarea::make('description_kk')->label('Описание (KK)')->visible(fn ($get) => $get('language') === 'kk')->columnSpanFull(),
            Textarea::make('description_en')->label('Описание (EN)')->visible(fn ($get) => $get('language') === 'en')->columnSpanFull(),

            FileUpload::make('images')
                ->label('Изображения asd')
                ->multiple()
                ->reorderable()
                ->image()
                ->disk('public')
                ->directory('catalog/items')

                ->columnSpanFull(),

            KeyValue::make('technical_specs_ru')
                ->label('Технические характеристики (RU)')
                ->visible(fn ($get) => $get('language') === 'ru')
                ->addButtonLabel('Добавить характеристику (RU)')
                ->columnSpanFull(),

            KeyValue::make('technical_specs_kk')
                ->label('Технические характеристики (KK)')
                ->visible(fn ($get) => $get('language') === 'kk')
                ->addButtonLabel('Добавить характеристику (KK)')
                ->columnSpanFull(),

            KeyValue::make('technical_specs_en')
                ->label('Технические характеристики (EN)')
                ->visible(fn ($get) => $get('language') === 'en')
                ->addButtonLabel('Добавить характеристику EN')
                ->columnSpanFull(),

            TextInput::make('slug')
                ->label('Slug')
                ->disabled()
                ->required()
                ->visible(fn ($get) => $get('language') === 'ru')
                ->dehydrated(fn ($state) => filled($state)),
        ]);
    }
}
