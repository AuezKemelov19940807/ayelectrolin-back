<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PriorityBlock extends Model
{
    protected $fillable = [
        'priority_id',
        'title_ru', 'title_en', 'title_kk',
        'description_ru', 'description_en', 'description_kk',
        'icon',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }
}
