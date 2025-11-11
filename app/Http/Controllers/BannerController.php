<?php

namespace App\Http\Controllers;

use App\Services\BannerService;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    protected BannerService $bannerService;

    public function __construct(BannerService $bannerService)
    {
        $this->bannerService = $bannerService;
    }

    public function index(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $banner = $this->bannerService->getBanner($lang);

        return response()->json(['banner' => $banner]);
    }

    public function update(Request $request)
    {
        $lang = $request->query('lang', 'ru');
        $banner = $this->bannerService->updateBanner($lang, $request->all());

        return response()->json([
            'message' => 'Banner updated successfully',
            'banner' => $banner,
        ]);
    }
}
