<?php

namespace App\Filament\Admin\Resources\CatalogItems\Pages;

use App\Filament\Admin\Resources\CatalogItems\CatalogItemResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCatalogItem extends EditRecord
{
    protected static string $resource = CatalogItemResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
