<?php

namespace App\Services;

use App\Models\CatalogSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogSeoService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getSeo(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $seo = CatalogSeo::first();

        if (! $seo) {
            $seo = CatalogSeo::create([
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
                'twitter_card' => null,
            ]);
        }

        return [
            'title' => $seo->{"title_{$lang}"} ?? '',
            'og_title' => $seo->{"og_title_{$lang}"} ?? '',
            'description' => $seo->{"description_{$lang}"} ?? '',
            'og_description' => $seo->{"og_description_{$lang}"} ?? '',
            'og_image' => $seo->og_image ? Storage::url($seo->og_image) : null,
            'twitter_card' => $seo->twitter_card ?? '',
        ];
    }

    public function updateSeo(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data, $request) {
            $seo = CatalogSeo::firstOrCreate([]);

            $seo->update([
                "title_{$lang}" => $data['title'] ?? $seo->{"title_{$lang}"},
                "og_title_{$lang}" => $data['og_title'] ?? $seo->{"og_title_{$lang}"},
                "description_{$lang}" => $data['description'] ?? $seo->{"description_{$lang}"},
                "og_description_{$lang}" => $data['og_description'] ?? $seo->{"og_description_{$lang}"},
                "twitter_card" => $data['twitter_card'] ?? $seo->twitter_card,
            ]);

            if (isset($data['og_image'])) {
                if ($request->hasFile('og_image')) {
                    $file = $request->file('og_image');
                    $seo->og_image = $file->store('seo', 'public');
                    $seo->save();
                } elseif (is_string($data['og_image'])) {
                    $seo->og_image = $data['og_image'];
                    $seo->save();
                }
            }

            return $this->getSeo($lang);
        });
    }
}
