<?php

namespace App\Filament\Admin\Resources\Contacts\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                // --- Переключатель языка ---
                ToggleButtons::make('language')
                    ->label('Язык')
                    ->options([
                        'ru' => 'RU',
                        'kk' => 'KK',
                        'en' => 'EN',
                    ])
                    ->inline()
                    ->default('ru')
                    ->reactive()
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if (! $state) {
                            $component->state('ru');
                        }
                    })
                    ->columnSpanFull(),

                // =======================
                //     AYELECTROLIN (СЛЕВА)
                // =======================
                FileUpload::make('ayelectrolin_logo')
                    ->label('Логотип Ayelectrolin (SVG)')
                    ->directory('contacts/logos')
                    ->disk('public')
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->maxSize(1024),

                FileUpload::make('zere_construction_logo')
                    ->label('Логотип Zere Construction (SVG)')
                    ->directory('contacts/logos')
                    ->disk('public')
                    ->acceptedFileTypes(['image/svg+xml'])
                    ->maxSize(1024),

                // --- RU ---
                TextInput::make('ayelectrolin_name_ru')
                    ->label('Название (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                TextInput::make('zere_construction_name_ru')
                    ->label('Название (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                TextInput::make('ayelectrolin_address_ru')
                    ->label('Адрес (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                TextInput::make('zere_construction_address_ru')
                    ->label('Адрес (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                // --- KK ---
                TextInput::make('ayelectrolin_name_kk')
                    ->label('Атауы (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                TextInput::make('zere_construction_name_kk')
                    ->label('Атауы (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                TextInput::make('ayelectrolin_address_kk')
                    ->label('Мекенжайы (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                TextInput::make('zere_construction_address_kk')
                    ->label('Мекенжайы (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                // --- EN ---
                TextInput::make('ayelectrolin_name_en')
                    ->label('Name (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                TextInput::make('zere_construction_name_en')
                    ->label('Name (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                TextInput::make('ayelectrolin_address_en')
                    ->label('Address (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                TextInput::make('zere_construction_address_en')
                    ->label('Address (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                TextInput::make('ayelectrolin_number')
                    ->label('Телефон')
                    ->tel(),

                TextInput::make('zere_construction_number')
                    ->label('Телефон')
                    ->tel(),

                TextInput::make('ayelectrolin_email')
                    ->label('Email')
                    ->email(),

                TextInput::make('zere_construction_email')
                    ->label('Email')
                    ->email(),

                // =======================
                //       КООРДИНАТЫ
                // =======================
                TextInput::make('latitude')
                    ->label('Широта (latitude)')
                    ->numeric()
                    ->step('any')
                    ->columnSpanFull(),

                TextInput::make('longitude')
                    ->label('Долгота (longitude)')
                    ->numeric()
                    ->step('any')
                    ->columnSpanFull(),
            ]);
    }
}
