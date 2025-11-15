<?php

namespace App\Services;

use App\Models\Priority;
use App\Models\PriorityBlock;
use Illuminate\Support\Facades\Storage;

class PriorityService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить приоритеты с блоками.
     */
    public function getPriority(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $priority = Priority::with('blocks')->first();

        if (! $priority) {
            $priority = Priority::create([
                'title_ru' => '',
                'description_ru' => '',
                'btnText_ru' => '',
                'title_en' => '',
                'description_en' => '',
                'btnText_en' => '',
                'title_kk' => '',
                'description_kk' => '',
                'btnText_kk' => '',
            ]);
        }

        return [
            'title' => $priority->{"title_{$lang}"} ?? '',
            'description' => $priority->{"description_{$lang}"} ?? '',
            'btnText' => $priority->{"btnText_{$lang}"} ?? '',
            'blocks' => $priority->blocks->map(function (PriorityBlock $block) use ($lang) {
                return [
                    'id' => $block->id,
                    'title' => $block->{"title_{$lang}"} ?? '',
                    'description' => $block->{"description_{$lang}"} ?? '',
                    'icon' => $block->icon ? Storage::url($block->icon) : null,
                ];
            }),
        ];
    }

    /**
     * Обновить или создать приоритеты.
     */
    public function updatePriority(string $lang, array $data): array
    {
        $lang = $this->normalizeLang($lang);

        $priority = Priority::firstOrCreate(['id' => 1]);

        $priority->update([
            "title_{$lang}" => $data['title'] ?? $priority->{"title_{$lang}"},
            "description_{$lang}" => $data['description'] ?? $priority->{"description_{$lang}"},
            "btnText_{$lang}" => $data['btnText'] ?? $priority->{"btnText_{$lang}"},
        ]);

        if (isset($data['blocks']) && is_array($data['blocks'])) {
            $existingIds = [];

            foreach ($data['blocks'] as $blockData) {
                if (! empty($blockData['id'])) {
                    $block = $priority->blocks()->find($blockData['id']);
                    if ($block) {
                        $block->update([
                            "title_{$lang}" => $blockData['title'] ?? '',
                            "description_{$lang}" => $blockData['description'] ?? '',
                            'icon' => $blockData['icon'] ?? null,
                        ]);
                        $existingIds[] = $block->id;

                        continue;
                    }
                }

                // Создаем новый блок
                $newBlock = $priority->blocks()->create([
                    "title_{$lang}" => $blockData['title'] ?? '',
                    "description_{$lang}" => $blockData['description'] ?? '',
                    'icon' => $blockData['icon'] ?? null,
                ]);

                $existingIds[] = $newBlock->id;
            }

            // ⚠️ не удаляем лишние блоки
        }

        // Формируем корректные URL для icon при возврате
        $blocks = collect($data['blocks'] ?? [])->map(function ($blockData) {
            return [
                'id' => $blockData['id'] ?? null,
                'title' => $blockData['title'] ?? '',
                'description' => $blockData['description'] ?? '',
                'icon' => isset($blockData['icon']) ? Storage::url($blockData['icon']) : null,
            ];
        });

        return [
            'title' => $priority->{"title_{$lang}"} ?? '',
            'description' => $priority->{"description_{$lang}"} ?? '',
            'btnText' => $priority->{"btnText_{$lang}"} ?? '',
            'blocks' => $blocks,
        ];
    }
}
