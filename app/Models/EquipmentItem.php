<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentItem extends Model
{
    protected $fillable = [
        'equipment_id',
        'title_ru',
        'title_kk',
        'title_en',
        'image',
        'large_image',
    ];

    protected static function booted(): void
    {
        static::creating(function ($item) {
            if (! $item->equipment_id) {
                $item->equipment_id = Equipment::first()?->id;
            }
        });

        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
