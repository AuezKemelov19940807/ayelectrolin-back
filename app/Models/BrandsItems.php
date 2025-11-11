<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BrandsItems extends Model
{
    protected $fillable = [
        'brand_id',
        'image',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brands::class, 'brand_id', 'id');
    }
}
