<?php

namespace App\Filament\Admin\Resources\Guarantees\Pages;

use App\Filament\Admin\Resources\Guarantees\GuaranteeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListGuarantees extends ListRecords
{
    protected static string $resource = GuaranteeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function mount(): void
    {
        // Редирект сразу на страницу редактирования баннера с ID = 2
        $this->redirect(static::getResource()::getUrl('edit', ['record' => 1]));
    }
}
