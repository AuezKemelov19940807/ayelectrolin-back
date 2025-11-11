<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'ayelectrolin_logo',
        'ayelectrolin_name_ru',
        'ayelectrolin_name_kk',
        'ayelectrolin_name_en',
        'ayelectrolin_number',
        'ayelectrolin_email',
        'ayelectrolin_address_ru',
        'ayelectrolin_address_kk',
        'ayelectrolin_address_en',
        'zere_construction_logo',
        'zere_construction_name_ru',
        'zere_construction_name_kk',
        'zere_construction_name_en',
        'zere_construction_number',
        'zere_construction_email',
        'zere_construction_address_ru',
        'zere_construction_address_kk',
        'zere_construction_address_en',
        'latitude',
        'longitude',
    ];

    /**
     * Каст координат в float при получении.
     */
    protected $casts = [
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    protected static function booted()
    {
        static::observe(\App\Observers\ImageToWebpObserver::class);
    }

    /**
     * Связь: один контакт имеет много соцсетей.
     */
    public function socials()
    {
        return $this->hasMany(Social::class);
    }

    /**
     * Геттер для объединённых координат.
     */
    public function getCoordinatesAttribute()
    {
        if ($this->latitude && $this->longitude) {
            return [
                'lat' => $this->latitude,
                'lng' => $this->longitude,
            ];
        }

        return null;
    }
}
