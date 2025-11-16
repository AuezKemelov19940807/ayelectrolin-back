<?php

namespace App\Filament\Admin\Resources\Projects\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class ProjectForm
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
                    ->columnSpan('full'),

                TextInput::make('title_kk')
                    ->label('Тақырып (KK)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('subtitle_ru')
                    ->label('Подзаголовок (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('subtitle_kk')
                    ->label('Субтитр (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('subtitle_en')
                    ->label('Subtitle (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                FileUpload::make('image_1')->image()->disk('public'),
                FileUpload::make('image_2')->image()->disk('public'),
                FileUpload::make('image_3')->image()->disk('public'),
                FileUpload::make('image_4')->image()->disk('public'),
                FileUpload::make('image_5')->image()->disk('public'),
                FileUpload::make('image_6')->image()->disk('public'),
                FileUpload::make('image_7')->image()->disk('public'),
            ]);
    }
}
