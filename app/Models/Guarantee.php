<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Guarantee extends Model
{
    protected $fillable = [
        'title_ru', 'title_en', 'title_kk',
    ];

    public function blocks()
    {
        return $this->hasMany(GuaranteeBlocks::class);
    }

    public function swipers()
    {
        return $this->hasMany(GuaranteeSwipers::class);
    }
}
