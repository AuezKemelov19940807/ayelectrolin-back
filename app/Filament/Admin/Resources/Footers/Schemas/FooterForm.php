<?php

namespace App\Filament\Admin\Resources\Footers\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class FooterForm
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
                            if ($record?->copy_ru) {
                                $component->state('ru');
                            } elseif ($record?->copy_en) {
                                $component->state('en');
                            } else {
                                $component->state('kk');
                            }
                        }
                    })
                    ->columnSpan('full'),

                // ---- RU ----
                TextInput::make('copy_ru')->label('Копирайт (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_text_ru')->label('Текст политики конфиденциальности (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_link_ru')->label('Ссылка на политику конфиденциальности (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_text_ru')->label('Текст политики Cookie (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_link_ru')->label('Ссылка на политику Cookie (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                // ---- KK ----
                TextInput::make('copy_kk')->label('Копирайт (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_text_kk')->label('Құпиялылық саясаты мәтіні (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_link_kk')->label('Құпиялылық саясаты сілтемесі (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_text_kk')->label('Cookie саясаты мәтіні (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_link_kk')->label('Cookie саясаты сілтемесі (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                // ---- EN ----
                TextInput::make('copy_en')->label('Copyright (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_text_en')->label('Privacy Policy Text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('privacy_policy_link_en')->label('Privacy Policy Link (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_text_en')->label('Cookie Policy Text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('cookie_policy_link_en')->label('Cookie Policy Link (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),
            ]);
    }
}
