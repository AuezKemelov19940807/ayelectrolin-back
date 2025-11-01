<?php

namespace App\Filament\Admin\Resources\Catalogs\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class SeoRelationManager extends RelationManager
{
    protected static string $relationship = 'seo';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
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
                ->default('ru')
                ->afterStateHydrated(function ($component, $state, $record) {
                    if (! $state) {
                        $lang = $record?->title_ru ? 'ru' :
                                ($record?->title_en ? 'en' : 'kk');
                        $component->state($lang);
                    }
                })
                ->columnSpanFull(),

            // Title
            TextInput::make('title_ru')
                ->label('Title (RU)')
                ->visible(fn($get) => $get('language') === 'ru')
                ->required(fn($get) => $get('language') === 'ru'),

            TextInput::make('title_kk')
                ->label('Title (KK)')
                ->visible(fn($get) => $get('language') === 'kk')
                ->required(fn($get) => $get('language') === 'kk'),

            TextInput::make('title_en')
                ->label('Title (EN)')
                ->visible(fn($get) => $get('language') === 'en')
                ->required(fn($get) => $get('language') === 'en'),

            // Description
            Textarea::make('description_ru')
                ->label('Description (RU)')
                ->visible(fn($get) => $get('language') === 'ru')
                ->columnSpanFull(),

            Textarea::make('description_kk')
                ->label('Description (KK)')
                ->visible(fn($get) => $get('language') === 'kk')
                ->columnSpanFull(),

            Textarea::make('description_en')
                ->label('Description (EN)')
                ->visible(fn($get) => $get('language') === 'en')
                ->columnSpanFull(),

            // Open Graph Title
            TextInput::make('og_title_ru')
                ->label('OG Title (RU)')
                ->visible(fn($get) => $get('language') === 'ru'),

            TextInput::make('og_title_kk')
                ->label('OG Title (KK)')
                ->visible(fn($get) => $get('language') === 'kk'),

            TextInput::make('og_title_en')
                ->label('OG Title (EN)')
                ->visible(fn($get) => $get('language') === 'en'),

            // Open Graph Description
            Textarea::make('og_description_ru')
                ->label('OG Description (RU)')
                ->visible(fn($get) => $get('language') === 'ru')
                ->columnSpanFull(),

            Textarea::make('og_description_kk')
                ->label('OG Description (KK)')
                ->visible(fn($get) => $get('language') === 'kk')
                ->columnSpanFull(),

            Textarea::make('og_description_en')
                ->label('OG Description (EN)')
                ->visible(fn($get) => $get('language') === 'en')
                ->columnSpanFull(),

            // Open Graph Image
            FileUpload::make('og_image')
                ->label('OG изображение')
                ->image()
                ->disk('public')
                ->directory('catalog/seo')
                ->columnSpanFull(),

            // Twitter card type
            TextInput::make('twitter_card')
                ->label('Тип Twitter-карточки (summary, large_image и т.д.)'),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('title_ru')->label('RU'),
                TextColumn::make('title_kk')->label('KK'),
                TextColumn::make('title_en')->label('EN'),
                ImageColumn::make('og_image')->label('OG Image'),
                TextColumn::make('twitter_card')->label('Twitter Card'),
                TextColumn::make('updated_at')->dateTime()->label('Обновлено'),
            ])
            ->headerActions([
                // CreateAction::make()
                    // ->mutateFormDataUsing(function (array $data, $livewire) {
                    //     $data['catalog_id'] = $livewire->ownerRecord->id ?? null;
                    //     return $data;
                    // }),
            ])
            ->recordActions([
                EditAction::make(),
                // DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}