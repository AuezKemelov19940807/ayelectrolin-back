<?php

namespace App\Filament\Admin\Resources\Catalogs\RelationManagers;

use Filament\Actions\AssociateAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\DissociateAction;
use Filament\Actions\DissociateBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\ToggleButtons;
use Filament\Resources\RelationManagers\RelationManager;

use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoriesRelationManager extends RelationManager
{
    protected static string $relationship = 'categories';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                // Выбор языка
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
                            $lang = $record?->category_ru ? 'ru' :
                                    ($record?->category_en ? 'en' : 'kk');
                            $component->state($lang);
                        }
                    })
                    ->columnSpan('full'),

                // Названия категорий по языкам
                TextInput::make('category_ru')
                    ->label('Категория (RU)')
                    ->required()
                    ->visible(fn ($get) => $get('language') === 'ru')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->columnSpan('full'),

                TextInput::make('category_kk')
                    ->label('Категория (KK)')
                    ->visible(fn ($get) => $get('language') === 'kk')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->columnSpan('full'),

                TextInput::make('category_en')
                    ->label('Category (EN)')
                    ->visible(fn ($get) => $get('language') === 'en')
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set) {
                        if ($state) {
                            $set('slug', Str::slug($state));
                        }
                    })
                    ->columnSpan('full'),

                // Slug — автоматический, disabled
                TextInput::make('slug')
                    ->label('Slug')
                    ->disabled()
                    ->required()
                    ->dehydrated(fn ($state) => true)
                    ->afterStateHydrated(function ($component, $state, $record) {
                        if ($record && ! $state) {
                            $component->state(
                                Str::slug($record->category_ru ?? $record->category_kk ?? $record->category_en)
                            );
                        }
                    })
                    ->columnSpan('full'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('category_ru')
            ->columns([
                TextColumn::make('category_ru')->searchable(),
                TextColumn::make('category_kk')->searchable(),
                TextColumn::make('category_en')->searchable(),
                TextColumn::make('slug')->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
                // AssociateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                // DissociateAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    // DissociateBulkAction::make(),
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    /**
     * Генерация slug перед созданием новой записи
     */
    protected function beforeCreate(array $data): array
    {
        $data['slug'] = Str::slug($data['category_ru'] ?? $data['category_kk'] ?? $data['category_en']);
        return $data;
    }

    /**
     * Генерация slug перед обновлением записи
     */
    protected function beforeSave(array $data): array
    {
        $data['slug'] = Str::slug($data['category_ru'] ?? $data['category_kk'] ?? $data['category_en']);
        return $data;
    }



}
