<?php

use Illuminate\Support\Facades\Route;

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