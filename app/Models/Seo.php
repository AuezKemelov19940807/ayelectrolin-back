<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seo extends Model
{
    protected $fillable = [
        // Title
        'title_ru',
        'title_kk',
        'title_en',

        // Open Graph title
        'og_title_ru',
        'og_title_kk',
        'og_title_en',

        // Description
        'description_ru',
        'description_kk',
        'description_en',

        // Open Graph description
        'og_description_ru',
        'og_description_kk',
        'og_description_en',

        // Image and Twitter card
        'og_image',
        'twitter_card',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

}
