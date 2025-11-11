<?php

namespace App\Services;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReviewService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getReview(string $lang): array
    {
        $lang = $this->normalizeLang($lang);
        $review = Review::with(['items'])->find(1);

        if (! $review) {
            // создаём пустую запись при первом обращении
            $review = Review::create([
                'title_ru' => '',
                'title_en' => '',
                'title_kk' => '',
            ]);
        }

        return [
            'id' => $review->id,
            'title' => $review->{"title_{$lang}"} ?? '',
            'items' => $review->items->map(fn ($item) => [
                'id' => $item->id,
                'description' => $item->{"description_{$lang}"} ?? '',
                'fullname' => $item->{"fullname_{$lang}"} ?? '',
            ]),
        ];
    }

    public function updateReview(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($data, $lang) {
            $review = Review::firstOrCreate(['id' => 1]);

            $review->update([
                "title_{$lang}" => $data['title'] ?? $review->{"title_{$lang}"},
            ]);

            if (isset($data['items'])) {
                $review->items()->delete();
                foreach ($data['items'] as $item) {
                    $guarantee->item()->create([
                        'description_ru' => $item['description'] ?? '',
                        'description_en' => $item['description'] ?? '',
                        'description_kk' => $item['description'] ?? '',
                        'fullname_ru' => $item['title'] ?? '',
                        'fullname_en' => $item['title'] ?? '',
                        'fullname_kk' => $item['title'] ?? '',
                    ]);
                }
            }

            return $this->getReview($lang);
        });
    }
}
