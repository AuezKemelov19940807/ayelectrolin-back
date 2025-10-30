<?php

namespace App\Filament\Admin\Resources\Catalogs\RelationManagers;

use App\Models\Category;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Schema $schema): Schema
    {
        return $schema->components([
            // Категория
            Select::make('category_id')
                ->label('Категория')
                ->required()
                ->options(function () {
                    $catalog = $this->ownerRecord;
                    return $catalog?->categories()
                        ->pluck('category_ru', 'id')
                        ->toArray() ?? [];
                })
                ->searchable()
                ->preload(),

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

            // Названия
            TextInput::make('title_ru')
                ->label('Название (RU)')
                ->required(fn($get) => $get('language') === 'ru')
                ->visible(fn($get) => $get('language') === 'ru')
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

            TextInput::make('title_kk')
                ->label('Название (KK)')
                ->visible(fn($get) => $get('language') === 'kk')
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

            TextInput::make('title_en')
                ->label('Название (EN)')
                ->visible(fn($get) => $get('language') === 'en')
                ->reactive()
                ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state ?? ''))),

            // Описание
            Textarea::make('description_ru')
                ->label('Описание (RU)')
                ->visible(fn($get) => $get('language') === 'ru')
                ->columnSpanFull(),

            Textarea::make('description_kk')
                ->label('Описание (KK)')
                ->visible(fn($get) => $get('language') === 'kk')
                ->columnSpanFull(),

            Textarea::make('description_en')
                ->label('Описание (EN)')
                ->visible(fn($get) => $get('language') === 'en')
                ->columnSpanFull(),

            // Изображения
            FileUpload::make('images')
                ->label('Изображения')
                ->multiple()
                ->reorderable()
                ->image()
                ->directory('catalog/items')
                ->columnSpanFull(),

            // Технические характеристики
            KeyValue::make('technical_specs')
                ->label('Технические характеристики')
                ->addButtonLabel('Добавить характеристику')
                ->columnSpanFull(),

            // Slug (readonly)
            TextInput::make('slug')
                ->label('Slug')
                ->disabled()
                ->required()
                ->dehydrated(fn($state) => filled($state)),
        ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title_ru')
            ->columns([
                TextColumn::make('category.category_ru')->label('Категория'),
                TextColumn::make('title_ru')->label('RU')->searchable(),
                TextColumn::make('title_kk')->label('KK')->searchable(),
                TextColumn::make('title_en')->label('EN')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('created_at')->dateTime()->sortable(),
                TextColumn::make('updated_at')->dateTime()->sortable(),
            ])
            ->filters([])
            ->headerActions([
                CreateAction::make()
                    ->mutateFormDataUsing(function (array $data, $livewire) {
                        $data['catalog_id'] = $livewire->ownerRecord->id ?? null;
                        $data['slug'] = Str::slug($data['title_ru'] ?? $data['title_kk'] ?? $data['title_en']);
                        return $data;
                    }),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected function beforeCreate(array $data): array
    {
        $data['slug'] = Str::slug($data['title_ru'] ?? $data['title_kk'] ?? $data['title_en']);
        return $data;
    }

    protected function beforeSave(array $data): array
    {
        $data['slug'] = Str::slug($data['title_ru'] ?? $data['title_kk'] ?? $data['title_en']);
        return $data;
    }
}
