<?php

namespace App\Services;

use App\Models\CatalogItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CatalogItemService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getItems(string $lang, ?string $categorySlug = null): array
    {
        $lang = $this->normalizeLang($lang);

        $query = CatalogItem::with('category');

        if ($categorySlug) {
            $query->whereHas('category', fn($q) => $q->where('slug', $categorySlug));
        }

        $items = $query->orderBy('id')->get();

        return $items->map(function ($item) use ($lang) {
            $firstImage = is_array($item->images) && !empty($item->images) ? Storage::url($item->images[0]) : null;

            return [
                'id' => $item->id,
                'title' => $item->{"title_{$lang}"} ?? '',
                'slug' => $item->slug,
                'image' => $firstImage,
                'category' => $item->category ? [
                    'id' => $item->category->id,
                    'slug' => $item->category->slug,
                ] : null,
            ];
        })->toArray();
    }

    public function getItemBySlug(string $slug, string $lang): ?array
    {
        $lang = $this->normalizeLang($lang);
        $item = CatalogItem::with('seo')->where('slug', $slug)->first();

        if (!$item) {
            return null;
        }

        if (!$item->seo) {
            $item->seo()->create([
                'title_ru' => '', 'title_kk' => '', 'title_en' => '',
                'og_title_ru' => '', 'og_title_kk' => '', 'og_title_en' => '',
                'description_ru' => '', 'description_kk' => '', 'description_en' => '',
                'og_description_ru' => '', 'og_description_kk' => '', 'og_description_en' => '',
                'og_image' => null, 'twitter_card' => '',
            ]);
            $item->load('seo');
        }

        $seo = $item->seo;

        return [
            'id' => $item->id,
            'title' => $item->{"title_{$lang}"} ?? '',
            'slug' => $item->slug,
            'description' => $item->{"description_{$lang}"} ?? '',
            'images' => collect($item->images)
                ->filter()
                ->map(fn($img) => Storage::url($img))
                ->values()
                ->toArray(),
            'technical_specs' => collect($item->{"technical_specs_{$lang}"} ?? [])
                ->map(fn($value, $key) => [
                    'title' => $key,
                    'description' => $value,
                ])
                ->values()
                ->toArray(),
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

    public function updateItemSeo(int $itemId, string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($itemId, $lang, $data, $request) {
            $item = CatalogItem::with('seo')->findOrFail($itemId);

            $seo = $item->seo ?? $item->seo()->create([
                'title_ru' => '', 'title_kk' => '', 'title_en' => '',
                'og_title_ru' => '', 'og_title_kk' => '', 'og_title_en' => '',
                'description_ru' => '', 'description_kk' => '', 'description_en' => '',
                'og_description_ru' => '', 'og_description_kk' => '', 'og_description_en' => '',
                'og_image' => null, 'twitter_card' => '',
            ]);

            $seo->update([
                "title_{$lang}" => $data['title'] ?? $seo->{"title_{$lang}"},
                "og_title_{$lang}" => $data['og_title'] ?? $seo->{"og_title_{$lang}"},
                "description_{$lang}" => $data['description'] ?? $seo->{"description_{$lang}"},
                "og_description_{$lang}" => $data['og_description'] ?? $seo->{"og_description_{$lang}"},
                "twitter_card" => $data['twitter_card'] ?? $seo->twitter_card,
            ]);

            if ($request->hasFile('og_image')) {
                $path = $request->file('og_image')->store('seo', 'public');
                $seo->og_image = $path;
                $seo->save();
            } elseif (!empty($data['og_image']) && is_string($data['og_image'])) {
                $seo->og_image = $data['og_image'];
                $seo->save();
            }

            return $this->getItemBySlug($item->slug, $lang);
        });
    }
}
