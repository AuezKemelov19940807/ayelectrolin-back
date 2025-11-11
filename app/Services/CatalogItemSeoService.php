<?php

namespace App\Services;

use App\Models\CatalogItem;
use App\Models\CatalogItemSeo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CatalogItemSeoService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить SEO для элемента каталога (с пустыми полями, если нет записи)
     */
    public function getSeo(int $itemId, string $lang): ?array
    {
        $lang = $this->normalizeLang($lang);
        $item = CatalogItem::with('seo')->find($itemId);

        if (! $item) {
            return null;
        }

        $seo = $item->seo;

        return [
            'title' => $seo?->{"title_{$lang}"} ?? '',
            'og_title' => $seo?->{"og_title_{$lang}"} ?? '',
            'description' => $seo?->{"description_{$lang}"} ?? '',
            'og_description' => $seo?->{"og_description_{$lang}"} ?? '',
            'og_image' => $seo && $seo->og_image ? Storage::url($seo->og_image) : null,
            'twitter_card' => $seo?->twitter_card ?? '',
        ];
    }

    /**
     * Обновить или создать SEO
     */
    public function updateSeo(int $itemId, string $lang, array $data, Request $request): CatalogItemSeo
    {
        $lang = $this->normalizeLang($lang);
        $item = CatalogItem::findOrFail($itemId);

        $seo = $item->seo ?? new CatalogItemSeo(['catalog_item_id' => $item->id]);

        // Обновляем только языкоспецифичные поля
        foreach (['title', 'og_title', 'description', 'og_description'] as $field) {
            if (isset($data[$field])) {
                $seo->setAttribute("{$field}_{$lang}", $data[$field]);
            }
        }

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('public/seo');
            $seo->og_image = $path;
        }

        if (isset($data['twitter_card'])) {
            $seo->twitter_card = $data['twitter_card'];
        }

        $seo->save();

        return $seo;
    }
}
