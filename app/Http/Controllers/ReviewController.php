<?php

namespace App\Http\Controllers;

use App\Services\ReviewService;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function __construct(private ReviewService $service) {}

    public function index()
    {
        return response()->json($this->service->getReview());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title_ru' => 'nullable|string',
            'title_kk' => 'nullable|string',
            'title_en' => 'nullable|string',
            'items' => 'array',
            'items.*.description_ru' => 'nullable|string',
            'items.*.description_kk' => 'nullable|string',
            'items.*.description_en' => 'nullable|string',
            'items.*.fullname_ru' => 'nullable|string',
            'items.*.fullname_kk' => 'nullable|string',
            'items.*.fullname_en' => 'nullable|string',
        ]);

        $result = $this->service->updateReview($data);

        return response()->json($result);
    }
}
