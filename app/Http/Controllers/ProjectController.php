<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected ProjectService $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * Получить данные проекта
     */
    public function index(Request $request): JsonResponse
    {
        $lang = $request->query('lang', 'ru');
        $data = $this->service->getProject($lang);

        return response()->json($data);
    }

    /**
     * Обновить данные проекта
     */
    public function update(Request $request): JsonResponse
    {
        $lang = $request->query('lang', 'ru');

        // Передача всех полей
        $data = $request->only([
            'title', 'subtitle',
            'image_1', 'image_2', 'image_3', 'image_4', 'image_5', 'image_6', 'image_7',
        ]);

        $result = $this->service->updateProject($lang, $data, $request);

        return response()->json($result);
    }
}
