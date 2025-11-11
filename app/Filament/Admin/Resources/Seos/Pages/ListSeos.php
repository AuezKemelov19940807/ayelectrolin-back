<?php

namespace App\Filament\Admin\Resources\Seos\Pages;

use App\Filament\Admin\Resources\Seos\SeoResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListSeos extends ListRecords
{
    protected static string $resource = SeoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function mount(): void
    {
       
        $this->redirect(static::getResource()::getUrl('edit', ['record' => 1]));
    }
}
