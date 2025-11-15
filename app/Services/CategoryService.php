<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryService
{
    protected array $allowedLangs = ['ru', 'kk', 'en'];

    protected function normalizeLang(string $lang): string
    {
        return in_array($lang, $this->allowedLangs) ? $lang : 'ru';
    }

    /**
     * Получить все категории
     */
    public function getCategories(string $lang): array
    {
        $lang = $this->normalizeLang($lang);

        $categories = Category::all();

        return $categories->map(function ($category) use ($lang) {
            return [
                'id' => $category->id,
                'title' => $category->{"category_{$lang}"} ?? '',
                'slug' => $category->slug,
            ];
        })->toArray();
    }

    /**
     * Создать или обновить категорию
     */
    public function saveCategory(array $data, Request $request, ?int $id = null): Category
    {
        return DB::transaction(function () use ($data, $id) {
            if ($id) {
                $category = Category::findOrFail($id);
                $category->update($data);
            } else {
                $category = Category::create($data);
            }

            return $category;
        });
    }

    /**
     * Получить категорию по slug вместе с items
     */
    public function getCategoryBySlug(string $slug, string $lang): array|null
    {
        $lang = $this->normalizeLang($lang);

        $category = Category::with('items')->where('slug', $slug)->first();
        if (! $category) return null;

        return [
              'id' => $category->id,
            'title' => $category->{"category_{$lang}"} ?? '',
            'slug' => $category->slug,
            'items' => $category->items->map(function ($item) use ($lang) {
                return [
                    'id' => $item->id,
                    'title' => $item->{"title_{$lang}"} ?? '',
                    'slug' => $item->slug,
                    'image' => $item->image ? json_decode($item->image) : [], // если image хранится как массив JSON
                    // 'description' => $item->{"description_{$lang}"} ?? '',
                    // 'technical_specs' => $item->technical_specs ?? [], // если есть поле technical_specs JSON
                ];
            })->toArray(),
        ];
    }
}
