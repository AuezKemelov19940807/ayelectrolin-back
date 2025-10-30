<?php

namespace App\Filament\Admin\Resources\CatalogItems\RelationManagers;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\DeleteBulkAction;

class SeoRelationManager extends RelationManager
{
    protected static string $relationship = 'seo';

    public function form(Schema $schema): Schema
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
    ->default('ru')
    ->reactive()
    ->afterStateHydrated(function ($component, $state, $record) {
        if ($record) {
            // Определяем язык по заполненным title
            if ($record->title_ru) {
                $component->state('ru');
            } elseif ($record->title_kk) {
                $component->state('kk');
            } elseif ($record->title_en) {
                $component->state('en');
            } else {
                $component->state('ru'); // fallback
            }
        }
    })
    ->columnSpanFull(),

                TextInput::make('title')
                    ->label('Title')
                    ->visible(fn($get) => $get('language') === 'ru')
                    ->dehydrated(fn($get) => $get('language') === 'ru')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->title_ru ?? '');
                    }),

                TextInput::make('title_kk')
                    ->label('Title KK')
                    ->visible(fn($get) => $get('language') === 'kk')
                    ->dehydrated(fn($get) => $get('language') === 'kk')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->title_kk ?? '');
                    }),

                TextInput::make('title_en')
                    ->label('Title EN')
                    ->visible(fn($get) => $get('language') === 'en')
                    ->dehydrated(fn($get) => $get('language') === 'en')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->title_en ?? '');
                    }),

                TextInput::make('og_title')
                    ->label('OG Title')
                    ->visible(fn($get) => $get('language') === 'ru')
                    ->dehydrated(fn($get) => $get('language') === 'ru')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->og_title_ru ?? '');
                    }),

                TextInput::make('og_title_kk')
                    ->label('OG Title KK')
                    ->visible(fn($get) => $get('language') === 'kk')
                    ->dehydrated(fn($get) => $get('language') === 'kk')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->og_title_kk ?? '');
                    }),

                TextInput::make('og_title_en')
                    ->label('OG Title EN')
                    ->visible(fn($get) => $get('language') === 'en')
                    ->dehydrated(fn($get) => $get('language') === 'en')
                    ->afterStateHydrated(function ($component, $state, $record) {
                        $component->state($record?->og_title_en ?? '');
                    }),

                Textarea::make('description')
                    ->label('Description')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'ru')
                    ->dehydrated(fn($get) => $get('language') === 'ru')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->description_ru ?? '')),

                Textarea::make('description_kk')
                    ->label('Description KK')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'kk')
                    ->dehydrated(fn($get) => $get('language') === 'kk')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->description_kk ?? '')),

                Textarea::make('description_en')
                    ->label('Description EN')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'en')
                    ->dehydrated(fn($get) => $get('language') === 'en')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->description_en ?? '')),

                Textarea::make('og_description')
                    ->label('OG Description')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'ru')
                    ->dehydrated(fn($get) => $get('language') === 'ru')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->og_description_ru ?? '')),

                Textarea::make('og_description_kk')
                    ->label('OG Description KK')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'kk')
                    ->dehydrated(fn($get) => $get('language') === 'kk')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->og_description_kk ?? '')),

                Textarea::make('og_description_en')
                    ->label('OG Description EN')
                    ->columnSpanFull()
                    ->visible(fn($get) => $get('language') === 'en')
                    ->dehydrated(fn($get) => $get('language') === 'en')
                    ->afterStateHydrated(fn($component, $state, $record) => $component->state($record?->og_description_en ?? '')),

                FileUpload::make('og_image')
                    ->label('OG Image')
                    ->image()
                    ->columnSpanFull(),

                TextInput::make('twitter_card')
                    ->label('Twitter Card Type')
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('title_ru')->searchable(),
                TextColumn::make('title_kk')->searchable(),
                TextColumn::make('title_en')->searchable(),
                ImageColumn::make('og_image'),
                TextColumn::make('twitter_card')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
