<?php

namespace App\Filament\Admin\Resources\Consultations;

use App\Filament\Admin\Resources\Consultations\Pages\CreateConsultation;
use App\Filament\Admin\Resources\Consultations\Pages\EditConsultation;
use App\Filament\Admin\Resources\Consultations\Pages\ListConsultations;
use App\Filament\Admin\Resources\Consultations\Schemas\ConsultationForm;
use App\Filament\Admin\Resources\Consultations\Tables\ConsultationsTable;
use App\Models\Consultation;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ConsultationResource extends Resource
{
    protected static ?string $model = Consultation::class;

    // Название в боковом меню
    protected static ?string $navigationLabel = 'Консультации';

    // Иконка
    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedChatBubbleLeftRight;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return ConsultationForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ConsultationsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListConsultations::route('/'),
            'create' => CreateConsultation::route('/create'),
            'edit' => EditConsultation::route('/{record}/edit'),
        ];
    }
}
