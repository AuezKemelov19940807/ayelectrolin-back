<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Main extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function banner()
    {
        return $this->hasOne(Banner::class);
    }

    public function equipment()
    {
        return $this->hasOne(Equipment::class);
    }

    public function priority()
    {
        return $this->hasOne(Priority::class);
    }

    public function guarantee()
    {
        return $this->hasOne(Guarantee::class);
    }

    public function brand()
    {
        return $this->hasOne(Brand::class);
    }
}
