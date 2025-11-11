<?php

namespace App\Http\Controllers;

use App\Services\BrandService;
use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function __construct(private BrandService $service) {}

    public function index()
    {
        return response()->json($this->service->getBrand());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title_ru' => 'nullable|string',
            'title_kk' => 'nullable|string',
            'title_en' => 'nullable|string',
            'items' => 'array',
            'items.*.image' => 'nullable|string',
        ]);

        $result = $this->service->updateBrand($data);

        return response()->json($result);
    }
}
