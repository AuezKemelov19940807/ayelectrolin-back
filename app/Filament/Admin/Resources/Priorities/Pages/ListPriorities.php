<?php

namespace App\Filament\Admin\Resources\Priorities\Pages;

use App\Filament\Admin\Resources\Priorities\PriorityResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPriorities extends ListRecords
{
    protected static string $resource = PriorityResource::class;

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
