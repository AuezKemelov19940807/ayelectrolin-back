<?php

namespace App\Services;

use App\Models\Guarantee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class GuaranteeService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getGuarantee(string $lang): array
    {
        $lang = $this->normalizeLang($lang);
        $guarantee = Guarantee::with(['blocks', 'swipers'])->find(1);

        if (! $guarantee) {
            // создаём пустую запись при первом обращении
            $guarantee = Guarantee::create([
                'title_ru' => '',
                'title_en' => '',
                'title_kk' => '',
            ]);
        }

        return [
            'id' => $guarantee->id,
            'title' => $guarantee->{"title_{$lang}"} ?? '',
            'blocks' => $guarantee->blocks->map(fn ($block) => [
                'id' => $block->id,
                'title' => $block->{"title_{$lang}"} ?? '',
                'description' => $block->{"description_{$lang}"} ?? '',
            ]),

            'swipers' => $guarantee->swipers->map(fn ($swiper) => [
                'id' => $swiper->id,
                // 'image' => $swiper->image ? Storage::url($swiper->image) : null,
            ]),
        ];
    }

    public function updateGuarantee(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($data, $lang) {
            $guarantee = Guarantee::firstOrCreate(['id' => 1]);

            $guarantee->update([
                "title_{$lang}" => $data['title'] ?? $guarantee->{"title_{$lang}"},
            ]);

            if (isset($data['blocks'])) {
                $guarantee->blocks()->delete();
                foreach ($data['blocks'] as $block) {
                    $guarantee->blocks()->create([
                        'title_ru' => $block['title'] ?? '',
                        'title_en' => $block['title'] ?? '',
                        'title_kk' => $block['title'] ?? '',
                        'description_ru' => $block['description'] ?? '',
                        'description_en' => $block['description'] ?? '',
                        'description_kk' => $block['description'] ?? '',
                    ]);
                }
            }

            if (isset($data['swipers'])) {
                $guarantee->swipers()->delete();
                foreach ($data['swipers'] as $swiper) {
                    $guarantee->swipers()->create([
                        'image' => $swiper['image'] ?? '',
                    ]);
                }
            }

            return $this->getGuarantee($lang);
        });
    }
}
