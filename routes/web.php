<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Auth;

Route::get('/whoami', function () {
    return [
        'auth' => Auth::check(),
        'user' => Auth::user(),
        'session' => session()->all()
    ];
});

Route::get('/', function () {
    if (Auth::check()) {
        // Если пользователь вошёл — отправляем в админку
        return redirect('/admin');
    }

    // Если не вошёл — на страницу входа
    return redirect('admin/login');
});


// Route::middleware('auth')->group(function () {
//   return redirect('/admin');
// });

Route::get('/admin/login', function () {
    return 'Страница входа (заглушка)';
})->name('login'); // 👈 добавили имя login

Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/admin');
    }
    return redirect('/admin/login');
});

Route::middleware('auth')->group(function () {
    Route::get('/admin', function () {
        return [
            'message' => 'Добро пожаловать в админку',
            'user' => Auth::user(),
        ];
    });
});