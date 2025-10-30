<?php

namespace App\Http\Controllers;

use App\Services\CatalogService;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    protected CatalogService $catalogService;

    public function __construct(CatalogService $catalogService)
    {
        $this->catalogService = $catalogService;
    }

    /**
     * GET /api/catalog?lang=ru
     */
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        return response()->json($this->catalogService->getCatalog($lang));
    }

    /**
     * PATCH /api/catalog?lang=ru
     */
    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $data = $request->all();

        return response()->json($this->catalogService->updateCatalog($lang, $data, $request));
    }
}
