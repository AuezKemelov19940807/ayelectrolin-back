<?php

namespace App\Filament\Admin\Resources\EquipmentItems\Pages;

use App\Filament\Admin\Resources\EquipmentItems\EquipmentItemResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListEquipmentItems extends ListRecords
{
    protected static string $resource = EquipmentItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
