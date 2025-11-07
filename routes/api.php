<?php

use App\Http\Controllers\BannerController;
use App\Http\Controllers\BitrixController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\EquipmentItemController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\PriorityController;
use App\Http\Controllers\FooterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CatalogItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CatalogItemSeoController;
use App\Http\Controllers\GuaranteeController;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
});

// Users
Route::resource('user', UserController::class)
    ->only(['index', 'store', 'show']);

// Bitrix
Route::prefix('bitrix')
    ->controller(BitrixController::class)
    ->group(function () {
        Route::post('contact', 'createContact');
        Route::post('deal', 'createDeal');
        Route::get('deals', 'listDeals');
    });

// Main
Route::resource('main', MainController::class)
    ->only(['index', 'store']);

// Banner
Route::resource('banner', BannerController::class)
    ->only(['index', 'update']);

// Equipment
Route::resource('equipment', EquipmentController::class)
    ->only(['index', 'update']);

// Equipment Item
Route::prefix('equipment')
    ->controller(EquipmentItemController::class)
    ->group(function () {
        Route::get('items', 'index');
        Route::post('items', 'store');
        Route::patch('items/{id}', 'update');
        Route::delete('items/{id}', 'destroy');
    });

// Priority
Route::prefix('priority')
    ->controller(PriorityController::class)
    ->group(function () {
        Route::get('/', 'index');   
        Route::patch('/', 'update'); 
    });

// Guarantee
Route::prefix('guarantee')
    ->controller(GuaranteeController::class)
    ->group(function () {
        Route::get('/', 'index');   
        Route::patch('/', 'update'); 
    });

// Footer
Route::prefix('footer')
    ->controller(FooterController::class)
    ->group(function () {
        Route::get('/', 'index');   
        Route::patch('/', 'update'); 
    });

// Contacts
Route::prefix('contacts')
    ->controller(ContactController::class)
    ->group(function () {
        Route::get('/', 'index');   
        Route::patch('/', 'update'); 
});

// Каталог
Route::prefix('catalog')
    ->group(function () {

        // Главная страница каталога + SEO
        Route::controller(CatalogController::class)->group(function () {
            Route::get('/', 'index');
            Route::patch('/', 'update');
        });

        // Категории каталога
        Route::prefix('categories')
            ->controller(CategoryController::class)
            ->group(function () {
                Route::get('/', 'index');
                Route::get('/{slug}', 'show');
                Route::post('/', 'store');
                Route::patch('/{id}', 'update');
                Route::delete('/{id}', 'destroy');
            });

        // Items каталога
        Route::prefix('items')
            ->group(function () {

                Route::controller(CatalogItemController::class)->group(function () {
                    Route::get('/', 'index');
                    Route::get('/{slug}', 'show');
                    Route::post('/', 'store');
                    Route::patch('/{id}', 'update');
                    Route::delete('/{id}', 'destroy');
                });

                // SEO конкретного item
                Route::prefix('{itemId}/seo')
                    ->controller(CatalogItemSeoController::class)
                    ->group(function () {
                        Route::get('/', 'show');
                        Route::patch('/', 'update');
                    });
            });
    });