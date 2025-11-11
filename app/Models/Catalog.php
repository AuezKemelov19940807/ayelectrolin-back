<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Catalog extends Model
{
    protected  $fillable = [
        // Title
        'title_ru',
        'title_kk',
        'title_en',

    ];

     public function seo(): HasOne
    {
        return $this->hasOne(CatalogSeo::class);
    }


    public function categories()
    {
    return $this->hasMany(Category::class);
    }


     public function items()
    {
        return $this->hasManyThrough(
            CatalogItem::class, // Целевая модель
            Category::class,    // Промежуточная модель
            'catalog_id',       // FK в Category
            'category_id',      // FK в CatalogItem
            'id',               // PK в Catalog
            'id'                // PK в Category
        );
    }


    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }


}
