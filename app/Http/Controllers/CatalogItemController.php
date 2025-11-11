<?php

namespace App\Http\Controllers;

use App\Services\CatalogItemService;
use Illuminate\Http\Request;

class CatalogItemController extends Controller
{
    protected CatalogItemService $service;

    public function __construct(CatalogItemService $service)
    {
        $this->service = $service;
    }

    /**
     * Список всех items, можно фильтровать по категории slug
     */
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ru');
        $categorySlug = $request->get('category_slug'); // опционально фильтр

        $items = $this->service->getItems($lang, $categorySlug);

        return response()->json($items);
    }

    /**
     * Детальный item по slug
     */
    public function show(Request $request, string $slug)
    {
        $lang = $request->get('lang', 'ru');

        $item = $this->service->getItemBySlug($slug, $lang);

        if (!$item) {
            return response()->json(['message' => 'Item not found'], 404);
        }

        return response()->json($item);
    }

    /**
     * Создать новый item
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'title_ru' => 'required|string',
            'title_kk' => 'nullable|string',
            'title_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_kk' => 'nullable|string',
            'description_en' => 'nullable|string',
            'slug' => 'required|string|unique:catalog_items,slug',
            'images' => 'nullable|array',
            'technical_specs_ru' => 'nullable|array',
            'technical_specs_kk' => 'nullable|array',
            'technical_specs_en' => 'nullable|array',
        ]);

        $item = $this->service->saveItem($data);

        return response()->json($item, 201);
    }

    /**
     * Обновить item
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'category_id' => 'nullable|exists:categories,id',
            'title_ru' => 'nullable|string',
            'title_kk' => 'nullable|string',
            'title_en' => 'nullable|string',
            'description_ru' => 'nullable|string',
            'description_kk' => 'nullable|string',
            'description_en' => 'nullable|string',
            'slug' => "nullable|string|unique:catalog_items,slug,{$id}",
            'images' => 'nullable|array',
            'technical_specs_ru' => 'nullable|array',
            'technical_specs_kk' => 'nullable|array',
            'technical_specs_en' => 'nullable|array',
        ]);

        $item = $this->service->saveItem($data, $id);

        return response()->json($item);
    }

    /**
     * Удалить item
     */
    public function destroy(int $id)
    {
        $item = \App\Models\CatalogItem::findOrFail($id);
        $item->delete();

        return response()->json(['message' => 'Item deleted']);
    }
}
