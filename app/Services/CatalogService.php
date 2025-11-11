<?php

namespace App\Services;

use App\Models\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить данные каталога
     */
    public function getCatalog(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $catalog = Catalog::with('seo')->first();

        if (!$catalog) {
            $catalog = Catalog::create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
            ]);

            $catalog->seo()->create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
                'og_title_ru' => '',
                'og_title_kk' => '',
                'og_title_en' => '',
                'description_ru' => '',
                'description_kk' => '',
                'description_en' => '',
                'og_description_ru' => '',
                'og_description_kk' => '',
                'og_description_en' => '',
                'og_image' => null,
                'twitter_card' => '',
            ]);
        }

        $seo = $catalog->seo;

        return [
            'id' => $catalog->id,
            'title' => $catalog->{"title_{$lang}"} ?? '',
            'seo' => [
                'title' => $seo->{"title_{$lang}"} ?? '',
                'og_title' => $seo->{"og_title_{$lang}"} ?? '',
                'description' => $seo->{"description_{$lang}"} ?? '',
                'og_description' => $seo->{"og_description_{$lang}"} ?? '',
                'og_image' => $seo->og_image ? Storage::url($seo->og_image) : null,
                'twitter_card' => $seo->twitter_card ?? '',
            ],
        ];
    }

    /**
     * Обновить каталог и SEO
     */
    public function updateCatalog(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data, $request) {
            $catalog = Catalog::with('seo')->firstOrCreate([]);

            $catalog->update([
                "title_{$lang}" => $data['title'] ?? $catalog->{"title_{$lang}"},
            ]);

            $seo = $catalog->seo ?? $catalog->seo()->create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
                'og_title_ru' => '',
                'og_title_kk' => '',
                'og_title_en' => '',
                'description_ru' => '',
                'description_kk' => '',
                'description_en' => '',
                'og_description_ru' => '',
                'og_description_kk' => '',
                'og_description_en' => '',
                'og_image' => null,
                'twitter_card' => '',
            ]);

            $seo->update([
                "title_{$lang}" => $data['seo']['title'] ?? $seo->{"title_{$lang}"},
                "og_title_{$lang}" => $data['seo']['og_title'] ?? $seo->{"og_title_{$lang}"},
                "description_{$lang}" => $data['seo']['description'] ?? $seo->{"description_{$lang}"},
                "og_description_{$lang}" => $data['seo']['og_description'] ?? $seo->{"og_description_{$lang}"},
                "twitter_card" => $data['seo']['twitter_card'] ?? $seo->twitter_card,
            ]);

            // Обработка og_image
            if (!empty($data['seo']['og_image'])) {
                if ($request->hasFile('seo.og_image')) {
                    $path = $request->file('seo.og_image')->store('seo', 'public');
                    $seo->og_image = $path;
                } elseif (is_string($data['seo']['og_image'])) {
                    $seo->og_image = $data['seo']['og_image'];
                }
                $seo->save();
            }

            return $this->getCatalog($lang);
        });
    }
}
