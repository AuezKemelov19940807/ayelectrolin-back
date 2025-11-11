<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = [
        'title_ru',
        'title_kk',
        'title_en',
        'description_ru',
        'description_kk',
        'description_en',
    ];

    public function main()
    {
        return $this->belongsTo(Main::class);
    }

    public function items()
    {
        return $this->hasMany(EquipmentItem::class);
    }
}
