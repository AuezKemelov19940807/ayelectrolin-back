<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $fillable = [
        'title_en', 'title_ru', 'title_kk',
        'subtitle_en', 'subtitle_ru', 'subtitle_kk',
        'btnText_en', 'btnText_ru', 'btnText_kk',
        'image',
        'main_id',
    ];

    public function main()
    {
        return $this->belongsTo(Main::class);
    }

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }
}
