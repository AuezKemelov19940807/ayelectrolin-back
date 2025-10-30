<?php

namespace App\Services;

use App\Models\Footer;
use Illuminate\Support\Facades\DB;

class FooterService
{
    /**
     * Разрешённые языки
     */
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    /**
     * Нормализует язык (если неизвестен — по умолчанию ru)
     */
    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить футер по языку
     */
    public function getFooter(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $footer = Footer::first();

        // если таблица пуста — создаём пустую запись
        if (! $footer) {
            $footer = Footer::create([
                'copy_ru' => '',
                'copy_kk' => '',
                'copy_en' => '',
                'privacy_policy_text_ru' => '',
                'privacy_policy_text_kk' => '',
                'privacy_policy_text_en' => '',
                'privacy_policy_link_ru' => '',
                'privacy_policy_link_kk' => '',
                'privacy_policy_link_en' => '',
                'cookie_policy_text_ru' => '',
                'cookie_policy_text_kk' => '',
                'cookie_policy_text_en' => '',
                'cookie_policy_link_ru' => '',
                'cookie_policy_link_kk' => '',
                'cookie_policy_link_en' => '',
            ]);
        }

        return [
            'id' => $footer->id,
            'copy' => $footer->{"copy_{$lang}"} ?? '',
            'privacy_policy' => [
                'text' => $footer->{"privacy_policy_text_{$lang}"} ?? '',
                'link' => $footer->{"privacy_policy_link_{$lang}"} ?? '',
            ],
            'cookie_policy' => [
                'text' => $footer->{"cookie_policy_text_{$lang}"} ?? '',
                'link' => $footer->{"cookie_policy_link_{$lang}"} ?? '',
            ],
        ];
    }

    /**
     * Обновить футер по языку
     */
    public function updateFooter(string $lang, array $data): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data) {
            $footer = Footer::firstOrCreate([]);

            $footer->update([
                "copy_{$lang}" => $data['copy'] ?? $footer->{"copy_{$lang}"},
                "privacy_policy_text_{$lang}" => $data['privacy_policy_text'] ?? $footer->{"privacy_policy_text_{$lang}"},
                "privacy_policy_link_{$lang}" => $data['privacy_policy_link'] ?? $footer->{"privacy_policy_link_{$lang}"},
                "cookie_policy_text_{$lang}" => $data['cookie_policy_text'] ?? $footer->{"cookie_policy_text_{$lang}"},
                "cookie_policy_link_{$lang}" => $data['cookie_policy_link'] ?? $footer->{"cookie_policy_link_{$lang}"},
            ]);

            // возвращаем обновлённые данные в формате getFooter
            return $this->getFooter($lang);
        });
    }
}
