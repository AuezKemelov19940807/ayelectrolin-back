<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CatalogItemSeoService;
use Illuminate\Http\Request;

class CatalogItemSeoController extends Controller
{
    protected CatalogItemSeoService $seoService;

    public function __construct(CatalogItemSeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function show(int $itemId, Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $seo = $this->seoService->getSeo($itemId, $lang);

        return response()->json($seo);
    }

    public function update(int $itemId, Request $request)
    {
        $lang = $request->query('lang', 'ru');

        $validated = $request->validate([
            'title' => 'nullable|string',
            'og_title' => 'nullable|string',
            'description' => 'nullable|string',
            'og_description' => 'nullable|string',
            'og_image' => 'nullable|file|image',
            'twitter_card' => 'nullable|string',
        ]);

        $seo = $this->seoService->updateSeo($itemId, $lang, $validated, $request);

        return response()->json($seo);
    }
}
