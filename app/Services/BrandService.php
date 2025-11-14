<?php

namespace App\Services;

use App\Models\Brands as Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BrandService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить бренд с его изображениями.
     */
    public function getBrand($lang): array
    {
        $lang = $this->normalizeLang($lang);

        $brand = Brand::with('items')->find(1);

        if (! $brand) {
            // создаём пустую запись при первом обращении
            $brand = Brand::create([
                'title_ru' => '',
                'title_en' => '',
                'title_kk' => '',
            ]);
        }

        return [
            'id' => $brand->id,
            'title' => $brand->{"title_{$lang}"} ?? '',
            'items' => $brand->items->map(fn ($item) => [
                'id' => $item->id,
                // 'image' => $item->image ? Storage::url($item->image) : null,
            ]),
        ];
    }

    /**
     * Создать или обновить бренд с изображениями.
     */
    public function updateBrand(int $id, string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($id, $lang, $data) {
            $brand = Brand::firstOrCreate(['id' => $id]);

            $brand->update([
                "title_{$lang}" => $data['title'] ?? $brand->{"title_{$lang}"},
            ]);

            if (isset($data['items'])) {
                // удаляем старые и добавляем новые
                $brand->items()->delete();

                foreach ($data['items'] as $item) {
                    // Если пришёл base64 или путь, сохраняем через Storage
                    $imagePath = $item['image'] ?? null;
                    if ($imagePath) {
                        // Можно сохранять файлы из base64:
                        // $path = Storage::put('brands', base64_decode($imagePath));
                        // Для простоты используем как есть:
                        $brand->items()->create([
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            return $this->getBrand($brand->id, $lang);
        });
    }
}
