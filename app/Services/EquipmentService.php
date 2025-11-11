<?php

namespace App\Services;

use App\Models\Main;
use Illuminate\Http\Request;

class EquipmentService
{
    protected EquipmentItemService $itemService;

    public function __construct(EquipmentItemService $itemService)
    {
        $this->itemService = $itemService;
    }

    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getEquipment(string $lang): array
    {
        $lang = $this->normalizeLang($lang);
        $main = Main::with('equipment')->first();

        if (! $main) {
            $main = Main::create();
        }

        $equipment = $main->equipment ?? $main->equipment()->create([
            'title_ru' => '',
            'description_ru' => '',
            'title_en' => '',
            'description_en' => '',
            'title_kk' => '',
            'description_kk' => '',
        ]);

        return [
            'title' => $equipment->{"title_{$lang}"} ?? '',
            'description' => $equipment->{"description_{$lang}"} ?? '',
            'items' => $this->itemService->getItems($equipment->id, $lang),
        ];
    }

    public function updateEquipment(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);
        $main = Main::firstOrCreate(['id' => 1]);

        $equipment = $main->equipment ?? $main->equipment()->create([
            'title_ru' => '', 'description_ru' => '',
            'title_en' => '', 'description_en' => '',
            'title_kk' => '', 'description_kk' => '',
        ]);

        $equipment->update([
            "title_{$lang}" => $data['title'] ?? $equipment->{"title_{$lang}"},
            "description_{$lang}" => $data['description'] ?? $equipment->{"description_{$lang}"},
        ]);

        // Обновление или добавление items
        if (isset($data['items']) && is_array($data['items'])) {
            foreach ($data['items'] as $itemData) {
                $this->itemService->saveItem($equipment->id, $itemData, $lang, $request);
            }
        }

        return [
            'title' => $equipment->{"title_{$lang}"},
            'description' => $equipment->{"description_{$lang}"},
            'items' => $this->itemService->getItems($equipment->id, $lang),
        ];
    }
}
