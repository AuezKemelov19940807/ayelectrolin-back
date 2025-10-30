<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReviewItem extends Model
{
    protected $fillable = [
        'review_id',
        'description_ru',
        'description_kk',
        'description_en',
        'fullname_ru',
        'fullname_kk',
        'fullname_en',
    ];

    public function review()
    {
        return $this->belongsTo(Review::class);
    }
}
