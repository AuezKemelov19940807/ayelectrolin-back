<?php

namespace App\Filament\Admin\Resources\Banners\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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

                TextInput::make('title_en')->label('Title (EN)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),
                TextInput::make('subtitle_en')->label('Subtitle (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),
                TextInput::make('btnText_en')->label('Button text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('title_ru')->label('Заголовок (RU)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),
                TextInput::make('subtitle_ru')->label('Подзаголовок (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),
                TextInput::make('btnText_ru')->label('Текст кнопки (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('title_kk')->label('Тақырып (KK)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),
                TextInput::make('subtitle_kk')->label('Астындағы мәтін (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),
                TextInput::make('btnText_kk')->label('Батырма мәтіні (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->columnSpan('full'),
            ]);
    }
}
