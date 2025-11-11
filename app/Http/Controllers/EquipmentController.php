<?php

namespace App\Http\Controllers;

use App\Services\EquipmentService;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    protected EquipmentService $equipmentService;

    public function __construct(EquipmentService $equipmentService)
    {
        $this->EquipmentService = $equipmentService;
    }

    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $equipment = $this->EquipmentService->getEquipment($lang);

        return response()->json(['equipment' => $equipment]);
    }

    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $equipment = $this->EquipmentService->updateEquipment($lang, $request->all());

        return response()->json([
            'message' => 'Banner updated successfully',
            'equipment' => $equipment,
        ]);
    }
}
