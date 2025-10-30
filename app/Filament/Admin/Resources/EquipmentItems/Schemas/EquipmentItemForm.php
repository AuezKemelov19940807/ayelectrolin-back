<?php

namespace App\Filament\Admin\Resources\EquipmentItems\Schemas;

use App\Models\Equipment;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Schemas\Schema;

class EquipmentItemForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('equipment_id')
                    ->default(fn () => Equipment::first()?->id),
                ToggleButtons::make('language')
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
                            if ($record && $record->title_ru) {
                                $component->state('ru');
                            } elseif ($record && $record->title_en) {
                                $component->state('en');
                            } else {
                                $component->state('kk');
                            }
                        }
                    })
                    ->columnSpan('full'),

                // Русский
                TextInput::make('title_ru')
                    ->label('Название (RU)')
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->required()
                    ->columnSpan('full'),

                // Казахский
                TextInput::make('title_kk')
                    ->label('Атауы (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->required()
                    ->columnSpan('full'),

                // Английский
                TextInput::make('title_en')
                    ->label('Title (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->required()
                    ->columnSpan('full'),

                // Изображения
                FileUpload::make('image')
                    ->label('Изображение')
                    ->image()
                    ->disk('public')
                    ->directory('equipment')
                    ->columnSpan('full'),

                FileUpload::make('large_image')
                    ->label('Большое изображение')
                    ->image()
                    ->disk('public')
                    ->directory('equipment_large')
                    ->columnSpan('full'),
            ]);
    }
}
