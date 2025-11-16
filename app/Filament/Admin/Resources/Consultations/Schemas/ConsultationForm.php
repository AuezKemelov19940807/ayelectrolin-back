<?php

namespace App\Filament\Admin\Resources\Consultations\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class ConsultationForm
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
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->required()
                    ->columnSpan('full'),

                TextInput::make('title_kk')
                    ->label('Тақырып (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->required()
                    ->columnSpan('full'),

                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->required()
                    ->columnSpan('full'),

                TextInput::make('phone_placeholder_ru')
                    ->label('Телефон (подсказка) (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')

                    ->columnSpan('full'),

                TextInput::make('phone_placeholder_kk')
                    ->label('Телефон (орын толтырғыш) (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')

                    ->columnSpan('full'),

                TextInput::make('phone_placeholder_en')
                    ->label('Phone (placeholder) (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')

                    ->columnSpan('full'),

                TextInput::make('name_placeholder_ru')
                    ->label('Имя (подсказка) (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('name_placeholder_kk')
                    ->label('Аты (орын толтырғыш) (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('name_placeholder_en')
                    ->label('Name (placeholder) (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('message_placeholder_ru')
                    ->label('Сообщение (подсказка) (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('message_placeholder_kk')
                    ->label('Хабарлама (орын толтырғыш) (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('message_placeholder_en')
                    ->label('Message (placeholder) (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('btn_text_ru')
                    ->label('Текст кнопки (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('btn_text_kk')
                    ->label('Түйме мәтіні (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('btn_text_en')
                    ->label('Button text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('note_text_ru')
                    ->label('Малый текст (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('note_text_kk')
                    ->label('Қосымша мәтін (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('note_text_en')
                    ->label('Small text (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),

                TextInput::make('contact_info_text_ru')
                    ->label('Заголовок контактной информации (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->columnSpan('full'),

                TextInput::make('contact_info_text_kk')
                    ->label('Байланыс ақпаратының тақырыбы  (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->columnSpan('full'),

                TextInput::make('contact_info_text_en')
                    ->label('Contact Information Title (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->columnSpan('full'),
            ]);
    }
}
