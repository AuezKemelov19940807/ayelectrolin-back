<?php

namespace App\Filament\Admin\Resources\Catalogs\Pages;

use App\Filament\Admin\Resources\Catalogs\CatalogResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCatalog extends CreateRecord
{
    protected static string $resource = CatalogResource::class;
}
