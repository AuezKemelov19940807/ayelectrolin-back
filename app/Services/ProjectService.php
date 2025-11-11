<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProjectService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить данные проекта
     */
    public function getProject(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $project = Project::first();

        if (! $project) {
            $project = Project::create([
                'title_ru' => '',
                'title_kk' => '',
                'title_en' => '',
                'subtitle_ru' => '',
                'subtitle_kk' => '',
                'subtitle_en' => '',
                'image_1' => null,
                'image_2' => null,
                'image_3' => null,
                'image_4' => null,
                'image_5' => null,
                'image_6' => null,
                'image_7' => null,
            ]);
        }

        return [
            'id' => $project->id,
            'title' => $project->{"title_{$lang}"} ?? '',
            'subtitle' => $project->{"subtitle_{$lang}"} ?? '',
            'image_1' => $project->image_1 ? Storage::url($project->image_1) : null,
            'image_2' => $project->image_2 ? Storage::url($project->image_2) : null,
            'image_3' => $project->image_3 ? Storage::url($project->image_3) : null,
            'image_4' => $project->image_4 ? Storage::url($project->image_4) : null,
            'image_5' => $project->image_5 ? Storage::url($project->image_5) : null,
            'image_6' => $project->image_6 ? Storage::url($project->image_6) : null,
            'image_7' => $project->image_7 ? Storage::url($project->image_7) : null,
        ];
    }

    /**
     * Обновить данные проекта
     */
    public function updateProject(string $lang, array $data, Request $request): array
    {
        $lang = $this->normalizeLang($lang);

        return DB::transaction(function () use ($lang, $data, $request) {
            $project = Project::firstOrCreate([]);

            // Обновляем заголовки и подзаголовки
            $project->update([
                "title_{$lang}" => $data['title'] ?? $project->{"title_{$lang}"},
                "subtitle_{$lang}" => $data['subtitle'] ?? $project->{"subtitle_{$lang}"},
            ]);

            // Обновляем изображения
            for ($i = 1; $i <= 7; $i++) {
                $field = "image_{$i}";
                if (isset($data[$field])) {
                    if ($request->hasFile($field)) {
                        $file = $request->file($field);
                        $path = $file->store('projects', 'public');
                        $project->{$field} = $path;
                        $project->save();
                    } elseif (is_string($data[$field])) {
                        $project->{$field} = $data[$field];
                        $project->save();
                    }
                }
            }

            return $this->getProject($lang);
        });
    }
}
