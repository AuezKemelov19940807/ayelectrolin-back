<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuaranteeBlocks extends Model
{
    protected $fillable = [
        'guarantee_id',
        'title_ru',
        'title_en',
        'title_kk',
        'description_ru',
        'description_en',
        'description_kk',
    ];

    public function guarantee()
    {
        return $this->belongsTo(Guarantee::class);
    }
}
