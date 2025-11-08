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
    if (Auth::check()) {
        // Если пользователь вошёл — отправляем в админку
        return redirect('/admin');
    }

    // Если не вошёл — на страницу входа
    return redirect('admin/login');
});


Route::middleware('auth')->group(function () {
  return redirect('/admin');
});