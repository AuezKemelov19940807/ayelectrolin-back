<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $fillable = [
        'title_ru',
        'title_kk',
        'title_en',
    ];

    public function items()
    {
        return $this->hasMany(ReviewItem::class);
    }
}
