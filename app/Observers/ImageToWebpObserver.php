<?php

namespace App\Observers;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ImageToWebpObserver
{
    public function saved($model)
    {

        foreach ($model->getAttributes() as $attribute => $value) {
            if (! is_string($value)) {
                continue;
            }

            if (preg_match('/\.(jpg|jpeg|png)$/i', $value)) {
                $this->convertToWebp($model, $attribute, $value);
            }
        }
    }

    protected function convertToWebp($model, string $attribute, string $path): void
    {
        $disk = Storage::disk('public');
        if (! $disk->exists($path)) {
            \Log::warning("⚠️ Файл не найден: {$path}");

            return;
        }

        $fullPath = $disk->path($path);
        $webpPath = preg_replace('/\.(jpg|jpeg|png)$/i', '.webp', $path);

        try {
            $manager = new ImageManager(new Driver);
            $image = $manager->read($fullPath);
            $disk->put($webpPath, $image->toWebp(90));
            $disk->delete($path);

            $model->updateQuietly([$attribute => $webpPath]);

        } catch (\Throwable $e) {
            \Log::error('❌ WebP conversion failed: '.$e->getMessage());
        }
    }
}
