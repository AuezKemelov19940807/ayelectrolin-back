<?php

namespace App\Filament\Admin\Resources\Banners\Pages;

use App\Filament\Admin\Resources\Banners\BannerResource;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Facades\Storage;

class EditBanner extends EditRecord
{
    protected static string $resource = BannerResource::class;


     protected function afterSave(): void
    {
        $banner = $this->record;

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            // Загружаем на GCS
            $gcsPath = Storage::disk('gcs')->putFile('banners', Storage::disk('public')->path($banner->image));

            // Обновляем путь в модели
            $banner->update(['image' => $gcsPath]);

            // Удаляем временный локальный файл
            Storage::disk('public')->delete($banner->image);
        }
    }

}
