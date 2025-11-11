<?php


namespace App\Http\Controllers;

use App\Services\GuaranteeService;
use Illuminate\Http\Request;

class GuaranteeController extends Controller
{
    public function __construct(private GuaranteeService $service) {}

    public function index()
    {
        return response()->json($this->service->getGuarantee());
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'title_ru' => 'nullable|string',
            'title_kk' => 'nullable|string',
            'title_en' => 'nullable|string',
            'blocks' => 'array',
            'blocks.*.title_ru' => 'nullable|string',
            'blocks.*.description_ru' => 'nullable|string',
            'swipers' => 'array',
            'swipers.*.image' => 'nullable|string',
        ]);

        $result = $this->service->updateGuarantee($data);

        return response()->json($result);
    }
}
