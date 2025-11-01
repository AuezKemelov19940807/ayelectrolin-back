<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Social extends Model
{
    protected $fillable = [
        'contact_id',
        'platform',
        'link',
        'icon',
    ];


    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

}
