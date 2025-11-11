<?php

namespace App\Filament\Admin\Resources\Banners\Pages;

use App\Filament\Admin\Resources\Banners\BannerResource;
use Filament\Resources\Pages\ListRecords;

class ListBanners extends ListRecords
{
    protected static string $resource = BannerResource::class;

    // убираем static
    protected string $view = 'filament.redirect-banner';

    public function mount(): void
    {
        // Редирект сразу на страницу редактирования баннера с ID = 2
        $this->redirect(static::getResource()::getUrl('edit', ['record' => 2]));
    }
}
