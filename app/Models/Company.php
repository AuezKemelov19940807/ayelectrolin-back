<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'title_ru', 'title_kk', 'title_en',
        'description_ru', 'description_kk', 'description_en',
        'image',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }
}
