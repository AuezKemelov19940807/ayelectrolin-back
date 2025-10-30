<?php

namespace App\Filament\Admin\Resources\CatalogItems\Pages;

use App\Filament\Admin\Resources\CatalogItems\CatalogItemResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalogItem extends CreateRecord
{
    protected static string $resource = CatalogItemResource::class;
}
