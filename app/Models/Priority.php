<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    protected $fillable = [
        'title_en',
        'title_ru',
        'title_kk',
        'description_ru',
        'description_kk',
        'description_en',
        'btnText_en',
        'btnText_ru',
        'btnText_kk',
    ];

    public function main()
    {
        return $this->belongsTo(Main::class);
    }

    public function blocks()
    {
        return $this->hasMany(PriorityBlock::class);
    }

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }
}
