<?php

namespace App\Http\Controllers;

use App\Services\CompanyService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function __construct(private CompanyService $service) {}

    /**
     * Получить данные компании
     */
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ru');
        $company = $this->service->getCompany($lang);

        return response()->json($company);
    }

    /**
     * Обновить данные компании
     */
    public function update(Request $request)
    {
        $lang = $request->get('lang', 'ru');

        $data = $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|file|image|max:5120', // 5MB
        ]);

        $company = $this->service->updateCompany($lang, $data, $request);

        return response()->json($company);
    }
}
