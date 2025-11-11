<?php

namespace App\Http\Controllers;

use App\Services\PriorityService;
use Illuminate\Http\Request;

class PriorityController extends Controller
{
    protected PriorityService $priorityService;

    public function __construct(PriorityService $priorityService)
    {
        $this->priorityService = $priorityService;
    }

    /**
     * Получить блок приоритетов (GET /api/priority?lang=ru)
     */
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $data = $this->priorityService->getPriority($lang);

        return response()->json($data);
    }

    /**
     * Обновить блок приоритетов (PUT /api/priority?lang=ru)
     */
    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $data = $request->all();

        $updated = $this->priorityService->updatePriority($lang, $data);

        return response()->json($updated);
    }
}
