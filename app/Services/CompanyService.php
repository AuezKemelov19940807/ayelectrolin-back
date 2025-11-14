<?php

namespace App\Services;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class CompanyService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить данные компании
     */
    public function getCompany(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $company = Company::first();

        if (! $company) {
            $company = Company::create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
                'description_ru' => '',
                'description_kk' => '',
                'description_en' => '',
                'image' => null,
            ]);
        }

        return [
            'id' => $company->id,
            'title' => $company->{"title_{$lang}"} ?? '',
            'description' => $company->{"description_{$lang}"} ?? '',
            // 'image' => $company->image ? Storage::url($company->image) : null,
        ];
    }

    /**
     * Обновить данные компании
     */
    public function updateCompany(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data, $request) {
            $company = Company::firstOrCreate([]);

            $company->update([
                "title_{$lang}" => $data['title'] ?? $company->{"title_{$lang}"},
                "description_{$lang}" => $data['description'] ?? $company->{"description_{$lang}"},
            ]);

            if (isset($data['image'])) {
                if ($request->hasFile('image')) {
                    $file = $request->file('image');
                    $path = $file->store('company', 'public');
                    $company->image = $path;
                    $company->save();
                } elseif (is_string($data['image'])) {
                    $company->image = $data['image'];
                    $company->save();
                }
            }

            return $this->getCompany($lang);
        });
    }
}
