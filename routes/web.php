<?php

use Illuminate\Support\Facades\Route;


use Illuminate\Support\Facades\Auth;

Route::get('/whoami', function () {
    return response()->json([
        'auth' => Auth::check(),
        'user' => Auth::user(),
        'session_id' => session()->getId(),
        'session_name' => config('session.cookie'),
        'session_driver' => config('session.driver'),
        'session_data' => session()->all(),
        'cookies' => request()->cookies->all(),
    ]);
});


Route::get('/', function () {
    return redirect(Auth::check() ? '/admin' : '/admin/login');
});

// 👇 защищаем /admin
Route::middleware(['web', 'auth'])->group(function () {
    // Route::get('/admin', function () {
        return redirect('/admin');
        // return response()->json([
        //     'message' => 'Добро пожаловать в админку',
        //     'redirect' => '/admin',
        //     'user' => Auth::user(),
        // ]);
    // });
});


Route::get('/test-secure', function () {
    return response()->json([
        'https_detected' => request()->isSecure(),   // true если HTTPS
        'scheme' => request()->getScheme(),         // http или https
        'full_url' => request()->fullUrl(),         // полный URL запроса
        'auth' => Auth::check(),                    // авторизован ли пользователь
        'user' => Auth::user(),                     // данные пользователя, если есть
        'session_id' => session()->getId(),         // текущий session_id
        'session_data' => session()->all(),        // все данные сессии
        'cookies' => request()->cookies->all(),    // текущие куки
        'headers' => [
            'X-Forwarded-Proto' => request()->header('X-Forwarded-Proto'),
            'X-Forwarded-For' => request()->header('X-Forwarded-For'),
        ],
    ]);
});

// Route::get('/', function () {
//     if (Auth::check()) {
//         // Если пользователь вошёл — отправляем в админку
//         return redirect('/admin');
//     }

//     // Если не вошёл — на страницу входа
//     return redirect('admin/login');
// });


// Route::middleware('auth')->group(function () {
//   return redirect('/admin');
// });