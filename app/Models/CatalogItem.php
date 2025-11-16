<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatalogItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title_ru', 'title_kk', 'title_en',
        'description_ru', 'description_kk', 'description_en',
        'slug',
        'images',
        'technical_specs_ru', 'technical_specs_kk', 'technical_specs_en',
    ];

    protected $casts = [
        'images' => 'array',
        'technical_specs_ru' => 'array',
        'technical_specs_kk' => 'array',
        'technical_specs_en' => 'array',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function seo()
    {
        return $this->hasOne(CatalogItemSeo::class, 'catalog_item_id');
    }
}
