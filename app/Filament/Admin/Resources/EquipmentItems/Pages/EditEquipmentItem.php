<?php

namespace App\Filament\Admin\Resources\EquipmentItems\Pages;

use App\Filament\Admin\Resources\EquipmentItems\EquipmentItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditEquipmentItem extends EditRecord
{
    protected static string $resource = EquipmentItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
