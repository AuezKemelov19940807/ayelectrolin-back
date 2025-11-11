<?php

namespace App\Filament\Admin\Resources\Priorities\Pages;

use App\Filament\Admin\Resources\Priorities\PriorityResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditPriority extends EditRecord
{
    protected static string $resource = PriorityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // DeleteAction::make(),
        ];
    }
}
