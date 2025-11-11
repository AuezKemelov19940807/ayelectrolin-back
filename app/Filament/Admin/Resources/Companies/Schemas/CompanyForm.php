<?php

namespace App\Filament\Admin\Resources\Companies\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class CompanyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                            // Автоматически выбираем язык по существующим данным
                            $lang = $record?->title_ru ? 'ru' :
                                    ($record?->title_en ? 'en' : 'kk');
                            $component->state($lang);
                        }
                    })
                    ->columnSpan('full'),

                TextInput::make('title_ru')
                    ->label('Название (RU)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('title_kk')
                    ->label('Аты (KK)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                Textarea::make('description_ru')
                    ->label('Описание (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full')
                    ->rows(3),

                Textarea::make('description_kk')
                    ->label('Сипаттама (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full')
                    ->rows(3),

                Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full')
                    ->rows(3),

                FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->disk('public')
                    ->columnSpanFull(),
            ]);
    }
}
