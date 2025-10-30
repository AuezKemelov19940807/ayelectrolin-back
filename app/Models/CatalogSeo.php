<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CatalogSeo extends Model
{

    protected $table = 'catalog_seos';

    protected $fillable = [
        'title_ru', 'title_kk', 'title_en',
        'og_title_ru', 'og_title_kk', 'og_title_en',
        'description_ru', 'description_kk', 'description_en',
        'og_description_ru', 'og_description_kk', 'og_description_en',
        'og_image',
        'twitter_card',
    ];

    public function catalog()
    {
        return $this->belongsTo(Catalog::class);
    }


    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }


}
