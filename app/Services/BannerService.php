<?php

namespace App\Services;

use App\Models\Main;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerService
{
    protected array $allowedLangs = ['ru', 'en', 'kk'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    public function getBanner(string $lang): array
    {
        $lang = $this->normalizeLang($lang);
        $main = Main::with('banner')->first();

        if (! $main) {
            $main = Main::create();
        }

        $banner = $main->banner ?? $main->banner()->create([
            'title_ru' => 'Hello',
            'subtitle_ru' => 'Yellow',
            'btnText_ru' => 'Shellow',
            'title_en' => '',
            'subtitle_en' => '',
            'btnText_en' => '',
            'title_kk' => '',
            'subtitle_kk' => '',
            'btnText_kk' => '',
            'image' => null,
        ]);

        return [
            'title' => $banner->{"title_{$lang}"} ?? '',
            'subtitle' => $banner->{"subtitle_{$lang}"} ?? '',
            'btnText' => $banner->{"btnText_{$lang}"} ?? '',
            'image' => $banner->image ? Storage::url($banner->image) : null,
        ];
    }

    public function updateBanner(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);
        $main = Main::firstOrCreate(['id' => 1]);

        $banner = $main->banner ?? $main->banner()->create([
            'title_ru' => '', 'subtitle_ru' => '', 'btnText_ru' => '',
            'title_en' => '', 'subtitle_en' => '', 'btnText_en' => '',
            'title_kk' => '', 'subtitle_kk' => '', 'btnText_kk' => '',
            'image' => null,
        ]);

        $banner->update([
            "title_{$lang}" => $data['title'] ?? $banner->{"title_{$lang}"},
            "subtitle_{$lang}" => $data['subtitle'] ?? $banner->{"subtitle_{$lang}"},
            "btnText_{$lang}" => $data['btnText'] ?? $banner->{"btnText_{$lang}"},
        ]);

        return [
            'title' => $banner->{"title_{$lang}"},
            'subtitle' => $banner->{"subtitle_{$lang}"},
            'btnText' => $banner->{"btnText_{$lang}"},
            'image' => $banner->image ? Storage::url($banner->image) : null,
        ];
    }
}
