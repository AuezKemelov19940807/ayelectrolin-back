<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class ContactController extends Controller
{
    public function __construct(
        protected ContactService $contactService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $lang = $request->query('lang', 'ru');
        $data = $this->contactService->getContact($lang);

        return response()->json($data);
    }

    public function update(Request $request): JsonResponse
    {
        $lang = $request->query('lang', 'ru');
        $data = $this->contactService->updateContact($lang, $request->all());

        return response()->json($data);
    }
}
