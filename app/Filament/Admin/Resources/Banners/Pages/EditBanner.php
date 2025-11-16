<?php

namespace App\Filament\Admin\Resources\Banners\Pages;

use App\Filament\Admin\Resources\Banners\BannerResource;
use Filament\Resources\Pages\EditRecord;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;

    public function getBreadcrumb(): string
    {
        return 'Редактировать';
    }

    public function getTitle(): string
    {
        return 'Редактировать баннер';
    }
}
