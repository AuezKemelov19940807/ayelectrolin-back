<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CatalogSeoService;
use Illuminate\Http\Request;

class CatalogSeoController extends Controller
{
    protected CatalogSeoService $seoService;

    public function __construct(CatalogSeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    /**
     * Получить SEO каталога
     */
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $seo = $this->seoService->getSeo($lang);

        return response()->json($seo);
    }

    /**
     * Обновить SEO каталога
     */
    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $validated = $request->validate([
            'title' => 'nullable|string',
            'og_title' => 'nullable|string',
            'description' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable',
            'twitter_card' => 'nullable|string',
        ]);

        $seo = $this->seoService->updateSeo($lang, $validated, $request);

        return response()->json($seo);
    }
}
