<?php

namespace App\Filament\Admin\Resources\Brands\Pages;

use App\Filament\Admin\Resources\Brands\BrandResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    // убираем static
    protected string $view = 'filament.redirect-banner';

    public function mount(): void
    {
        // Редирект сразу на страницу редактирования баннера с ID = 2
        $this->redirect(static::getResource()::getUrl('edit', ['record' => 1]));
    }
}
