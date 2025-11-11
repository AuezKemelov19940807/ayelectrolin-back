<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ConsultationService;
use Illuminate\Http\Request;

class ConsultationController extends Controller
{
    protected ConsultationService $service;

    public function __construct(ConsultationService $service)
    {
        $this->service = $service;
    }

    /**
     * Получить данные консультации
     */
    public function index(string $lang)
    {
        $data = $this->service->getConsultation($lang);

        return response()->json($data);
    }

    /**
     * Обновить данные консультации
     */
    public function update(string $lang, Request $request)
    {
        $data = $this->service->updateConsultation($lang, $request->all());

        return response()->json($data);
    }
}
