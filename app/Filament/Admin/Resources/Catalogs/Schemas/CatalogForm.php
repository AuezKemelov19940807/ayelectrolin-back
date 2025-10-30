<?php

namespace App\Filament\Admin\Resources\Catalogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class CatalogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Переключатель языка
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
                            // Автоматический выбор языка по существующим данным
                            $lang = $record?->title_ru ? 'ru' :
                                    ($record?->title_en ? 'en' : 'kk');
                            $component->state($lang);
                        }
                    })
                    ->columnSpan('full'),

                // RU
                TextInput::make('title_ru')
                    ->label('Название (RU)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                // KK
                TextInput::make('title_kk')
                    ->label('Аты (KK)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                // EN
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),
            ]);
    }

}
