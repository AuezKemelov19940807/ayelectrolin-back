<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brands extends Model
{
    protected $fillable = [
        'title_en', 'title_ru', 'title_kk',

    ];

    public function items()
    {
        return $this->hasMany(BrandsItems::class, 'brand_id', 'id');
    }
}
