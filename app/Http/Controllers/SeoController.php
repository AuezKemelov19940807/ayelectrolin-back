<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\SeoService;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    protected SeoService $seoService;

    public function __construct(SeoService $seoService)
    {
        $this->seoService = $seoService;
    }

    public function index(string $lang)
    {
        return response()->json($this->seoService->getSeo($lang));
    }

    public function update(Request $request, string $lang)
    {
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
