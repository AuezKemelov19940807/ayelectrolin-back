<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuaranteeSwipers extends Model
{
    protected $fillable = [
        'guarantee_id',
        'image',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }
}
