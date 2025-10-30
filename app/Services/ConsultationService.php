<?php

namespace App\Services;

use App\Models\Consultation;
use Illuminate\Support\Facades\DB;

class ConsultationService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить данные консультации
     */
    public function getConsultation(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $consultation = Consultation::first();

        if (! $consultation) {
            $consultation = Consultation::create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
                'phone_placeholder_ru' => '',
                'phone_placeholder_kk' => '',
                'phone_placeholder_en' => '',
                'name_placeholder_ru' => '',
                'name_placeholder_kk' => '',
                'name_placeholder_en' => '',
                'message_placeholder_ru' => '',
                'message_placeholder_kk' => '',
                'message_placeholder_en' => '',
                'btn_text_ru' => '',
                'btn_text_kk' => '',
                'btn_text_en' => '',
                'note_text_ru' => '',
                'note_text_kk' => '',
                'note_text_en' => '',
                'contact_info_text_ru' => '',
                'contact_info_text_kk' => '',
                'contact_info_text_en' => '',
            ]);
        }

        return [
            'id' => $consultation->id,
            'title' => $consultation->{"title_{$lang}"},
            'phone_placeholder' => $consultation->{"phone_placeholder_{$lang}"},
            'name_placeholder' => $consultation->{"name_placeholder_{$lang}"},
            'message_placeholder' => $consultation->{"message_placeholder_{$lang}"},
            'btn_text' => $consultation->{"btn_text_{$lang}"},
            'note_text' => $consultation->{"note_text_{$lang}"},
            'contact_info_text' => $consultation->{"contact_info_text_{$lang}"},
        ];
    }

    /**
     * Обновить данные консультации
     */
    public function updateConsultation(string $lang, array $data): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data) {
            $consultation = Consultation::firstOrCreate([]);

            $consultation->update([
                "title_{$lang}" => $data['title'] ?? $consultation->{"title_{$lang}"},
                "phone_placeholder_{$lang}" => $data['phone_placeholder'] ?? $consultation->{"phone_placeholder_{$lang}"},
                "name_placeholder_{$lang}" => $data['name_placeholder'] ?? $consultation->{"name_placeholder_{$lang}"},
                "message_placeholder_{$lang}" => $data['message_placeholder'] ?? $consultation->{"message_placeholder_{$lang}"},
                "btn_text_{$lang}" => $data['btn_text'] ?? $consultation->{"btn_text_{$lang}"},
                "note_text_{$lang}" => $data['note_text'] ?? $consultation->{"note_text_{$lang}"},
                "contact_info_text_{$lang}" => $data['contact_info_text'] ?? $consultation->{"contact_info_text_{$lang}"},
            ]);

            return $this->getConsultation($lang);
        });
    }
}
