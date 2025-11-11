<?php

namespace App\Http\Controllers;

use App\Services\FooterService;
use Illuminate\Http\Request;

class FooterController extends Controller
{
    protected FooterService $footerService;

    public function __construct(FooterService $footerService)
    {
        $this->footerService = $footerService;
    }

    /**
     * Получить футер (GET /api/footer?lang=ru)
     */
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        return response()->json(
            $this->footerService->getFooter($lang)
        );
    }

    /**
     * Обновить футер (PUT /api/footer?lang=ru)
     */
    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $validated = $request->validate([
            'copy' => 'nullable|string',
            'privacy_policy_text' => 'nullable|string',
            'privacy_policy_link' => 'nullable|string',
            'cookie_policy_text' => 'nullable|string',
            'cookie_policy_link' => 'nullable|string',
        ]);

        return response()->json(
            $this->footerService->updateFooter($lang, $validated)
        );
    }
}
