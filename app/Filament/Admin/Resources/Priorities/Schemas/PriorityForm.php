<?php

namespace App\Filament\Admin\Resources\Priorities\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class PriorityForm
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
                            if ($record->title_ru) {
                                $component->state('ru');
                            } elseif ($record->title_en) {
                                $component->state('en');
                            } else {
                                $component->state('kk');
                            }
                        }
                    })
                    ->columnSpan('full'),

                // 🇷🇺 Русский
                TextInput::make('title_ru')
                    ->label('Заголовок (RU)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('description_ru')
                    ->label('Описание (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('btnText_ru')
                    ->label('Текст кнопки (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                // 🇰🇿 Қазақша
                TextInput::make('title_kk')
                    ->label('Тақырып (KK)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('description_kk')
                    ->label('Сипаттама (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('btnText_kk')
                    ->label('Батырма мәтіні (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                // 🇬🇧 English
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('description_en')
                    ->label('Description (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('btnText_en')
                    ->label('Button text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                // Привязка к Main (если нужно)
                // TextInput::make('main_id')
                //     ->label('Main ID')
                //     ->numeric()
                //     ->columnSpan('full'),
            ]);
    }
}
