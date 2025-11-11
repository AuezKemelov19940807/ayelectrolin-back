<?php

namespace App\Http\Controllers;

use App\Services\EquipmentItemService;
use Illuminate\Http\Request;

class EquipmentItemController extends Controller
{
    public function __construct(
        protected EquipmentItemService $equipmentItemService
    ) {}

    // Получить все items
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        return response()->json(
            $this->equipmentItemService->getItems($lang)
        );
    }

    // Создать item
    public function store(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $data = $request->all();

        // ❗ аргументы должны быть ($data, $lang, $request)
        $item = $this->equipmentItemService->createItem($data, $lang, $request);

        return response()->json($item, 201);
    }

    // Обновить item
    public function update(int $id, Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $data = $request->all();

        $item = $this->equipmentItemService->updateItem($id, $data, $lang, $request);

        return response()->json($item);
    }

    // Удалить item
    public function destroy(int $id)
    {
        $deleted = $this->equipmentItemService->deleteItem($id);

        return response()->json(['deleted' => $deleted]);
    }
}
