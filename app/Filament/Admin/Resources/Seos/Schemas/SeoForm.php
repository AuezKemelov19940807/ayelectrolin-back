<?php

namespace App\Filament\Admin\Resources\Seos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class SeoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Переключатель языка
                ToggleButtons::make('language')
                    ->label('Язык')
                    ->options([
                        'ru' => 'RU',
                        'kk' => 'KK',
                        'en' => 'EN',
                    ])
                    ->inline()
                    ->reactive()
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if (! $state) {
                            if ($record?->title_ru) {
                                $component->state('ru');
                            } elseif ($record?->title_en) {
                                $component->state('en');
                            } else {
                                $component->state('kk');
                            }
                        }
                    })
                    ->columnSpan('full'),

                // --- RU ---
                TextInput::make('title_ru')
                    ->label('Title (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                TextInput::make('og_title_ru')
                    ->label('OG Title (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru'),

                Textarea::make('description_ru')
                    ->label('Description (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpanFull(),

                Textarea::make('og_description_ru')
                    ->label('OG Description (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpanFull(),

                // --- KK ---
                TextInput::make('title_kk')
                    ->label('Title (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                TextInput::make('og_title_kk')
                    ->label('OG Title (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk'),

                Textarea::make('description_kk')
                    ->label('Description (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpanFull(),

                Textarea::make('og_description_kk')
                    ->label('OG Description (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpanFull(),

                // --- EN ---
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                TextInput::make('og_title_en')
                    ->label('OG Title (EN)')
                    ->visible(fn ($get) => $get('language') === 'en'),

                Textarea::make('description_en')
                    ->label('Description (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpanFull(),

                Textarea::make('og_description_en')
                    ->label('OG Description (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpanFull(),

                // --- Общие поля ---
                FileUpload::make('og_image')
                    ->label('OG Image')
                    ->directory('seo')
                    ->disk('public')
                    ->image()
                    ->columnSpanFull(),

                Select::make('twitter_card')
                    ->label('Twitter Card')
                    ->options([
                        'summary' => 'Summary',
                        'summary_large_image' => 'Summary Large Image',
                        'app' => 'App',
                        'player' => 'Player',
                    ])
                    ->columnSpanFull()
                    ->required(false),
            ]);
    }
}
