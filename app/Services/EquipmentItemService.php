<?php

namespace App\Services;

use App\Models\EquipmentItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentItemService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить все items для конкретного оборудования.
     */
    public function getItems(int $equipmentId, string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $items = EquipmentItem::where('equipment_id', $equipmentId)->get();

        return $items->map(function (EquipmentItem $item) use ($lang) {
            return [
                'id' => $item->id,
                'title' => $item->{"title_{$lang}"} ?? '',
                'image' => $item->image ? "https://storage.googleapis.com/ayelectrolin-storage/public/{$item->image}" : null,
                // 'image' => $item->image ? Storage::url($item->image) : null,
                // 'largeImage' => $item->large_image ? Storage::url($item->large_image) : null,
            ];
        })->toArray();
    }

    public function createItem(int $equipmentId, array $data, string $lang): EquipmentItem
    {
        $lang = $this->normalizeLang($lang);

        return EquipmentItem::create([
            'equipment_id' => $equipmentId,
            "title_{$lang}" => $data['title'] ?? '',
            'image' => $data['image'] ?? null,
            'large_image' => $data['largeImage'] ?? null,
        ]);
    }

    public function updateItem(int $itemId, array $data, string $lang): EquipmentItem
    {
        $lang = $this->normalizeLang($lang);
        $item = EquipmentItem::findOrFail($itemId);

        $item->update([
            "title_{$lang}" => $data['title'] ?? $item->{"title_{$lang}"},
            'image' => $data['image'] ?? $item->image,
            'large_image' => $data['largeImage'] ?? $item->large_image,
        ]);

        return $item;
    }

    public function deleteItem(int $id): bool
    {
        return EquipmentItem::where('id', $id)->delete() > 0;
    }

    public function saveItem(int $equipmentId, array $data, string $lang, Request $request): EquipmentItem
    {
        if (! empty($data['id'])) {
            return $this->updateItem($data['id'], $data, $lang);
        }

        return $this->createItem($equipmentId, $data, $lang);
    }
}
