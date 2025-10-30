<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    /**
     * Список всех категорий
     */
    public function index(Request $request)
    {
        $lang = $request->get('lang', 'ru');

        $categories = $this->service->getCategories($lang);

        return response()->json([
           
            'data' => $categories,
        ]);
    }

    /**
     * Получить категорию по slug вместе с items
     */
    public function show(Request $request, string $slug)
    {
        $lang = $request->get('lang', 'ru');

        $category = $this->service->getCategoryBySlug($slug, $lang);

        if (! $category) {
            return response()->json([
                'success' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
          
            'data' => $category,
        ]);
    }

    /**
     * Создать новую категорию
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'category_ru' => 'nullable|string',
            'category_kk' => 'nullable|string',
            'category_en' => 'nullable|string',
            'slug' => 'required|string|unique:categories,slug',
        ]);

        $category = $this->service->saveCategory($data, $request);

        return response()->json([
         
            'data' => $category,
        ]);
    }

    /**
     * Обновить категорию
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'category_ru' => 'nullable|string',
            'category_kk' => 'nullable|string',
            'category_en' => 'nullable|string',
            'slug' => "required|string|unique:categories,slug,{$id}",
        ]);

        $category = $this->service->saveCategory($data, $request, $id);

        return response()->json([
            
            'data' => $category,
        ]);
    }

    /**
     * Удалить категорию
     */
    public function destroy(int $id)
    {
        $category = $this->service->saveCategory([], request(), $id);

        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
