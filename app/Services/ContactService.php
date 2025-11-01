<?php

namespace App\Services;

use App\Models\Contact;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class ContactService
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
     * Получить контакт по языку
     */
    public function getContact(string $lang): array
    {
        $lang = $this->normalizeLang($lang);
        $contact = Contact::with('socials')->first();

        // если таблица пуста — создаём пустую запись
        if (! $contact) {
            $contact = Contact::create();
        }

        return [
            'id' => $contact->id,
            'ayelectrolin' => [
                'logo' => $contact->ayelectrolin_logo ? Storage::url($contact->ayelectrolin_logo) : null,
                'name' => $contact->{"ayelectrolin_name_{$lang}"} ?? '',
                'number' => $contact->ayelectrolin_number ?? '',
                'email' => $contact->ayelectrolin_email ?? '',
                'address' => $contact->{"ayelectrolin_address_{$lang}"} ?? '',
            ],
            'zere_construction' => [
                'logo' => $contact->zere_construction_logo ? Storage::url($contact->zere_construction_logo) : null,
                'name' => $contact->{"zere_construction_name_{$lang}"} ?? '',
                'number' => $contact->zere_construction_number ?? '',
                'email' => $contact->zere_construction_email ?? '',
                'address' => $contact->{"zere_construction_address_{$lang}"} ?? '',
            ],
            'coordinates' => [
                'lat' => $contact->latitude,
                'lng' => $contact->longitude,
            ],
             'socials' => $contact->socials
                ? $contact->socials->map(fn ($s) => [
                'id' => $s->id,
                'platform' => $s->platform,
                'link' => $s->link,
                'icon' => $s->icon ? Storage::url($s->icon) : null,
            ])->toArray()
            : [],
        ];
    }

    /**
     * Обновить контакт по языку
     */
    public function updateContact(string $lang, array $data): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data) {
            $contact = Contact::firstOrCreate([]);

            $contact->update([
                "ayelectrolin_name_{$lang}" => $data['ayelectrolin_name'] ?? $contact->{"ayelectrolin_name_{$lang}"},
                "ayelectrolin_address_{$lang}" => $data['ayelectrolin_address'] ?? $contact->{"ayelectrolin_address_{$lang}"},
                "zere_construction_name_{$lang}" => $data['zere_construction_name'] ?? $contact->{"zere_construction_name_{$lang}"},
                "zere_construction_address_{$lang}" => $data['zere_construction_address'] ?? $contact->{"zere_construction_address_{$lang}"},
                'ayelectrolin_logo' => $data['ayelectrolin_logo'] ?? $contact->ayelectrolin_logo,
                'ayelectrolin_number' => $data['ayelectrolin_number'] ?? $contact->ayelectrolin_number,
                'ayelectrolin_email' => $data['ayelectrolin_email'] ?? $contact->ayelectrolin_email,
                'zere_construction_logo' => $data['zere_construction_logo'] ?? $contact->zere_construction_logo,
                'zere_construction_number' => $data['zere_construction_number'] ?? $contact->zere_construction_number,
                'zere_construction_email' => $data['zere_construction_email'] ?? $contact->zere_construction_email,
                'latitude' => $data['latitude'] ?? $contact->latitude,
                'longitude' => $data['longitude'] ?? $contact->longitude,
            ]);

             if (isset($data['socials']) && is_array($data['socials'])) {
                foreach ($data['socials'] as $s) {
                    $social = $contact->socials()->find($s['id']);
                    if ($social) {
                        $social->update([
                            'platform' => $s['platform'] ?? $social->platform,
                            'link' => $s['link'] ?? $social->link,
                            'icon' => $s['icon'] ?? $social->icon,
                        ]);
                    }
                }
            }

            return $this->getContact($lang);
        });
    }
}
