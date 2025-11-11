<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_ru',
        'category_kk',
        'category_en',
        'slug',
    ];

    /**
     * Связь с каталогом: категория имеет много items
     */
    public function items()
    {
        return $this->hasMany(CatalogItem::class);
    }

    public function catalog()
    {
    return $this->belongsTo(Catalog::class);
    }


}
