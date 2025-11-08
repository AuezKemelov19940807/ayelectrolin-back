<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

  public function boot(): void
    {
        // Чтобы старые миграции с VARCHAR(255) работали на старых MySQL
        Schema::defaultStringLength(191);

        // Форсируем HTTPS только на production
        if (app()->environment('production')) {
            URL::forceScheme('https');
        }
    }
}