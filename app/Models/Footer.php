<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Footer extends Model
{
    protected $fillable = [
        'copy_ru',
        'copy_kk',
        'copy_en',

        'privacy_policy_text_ru',
        'privacy_policy_text_kk',
        'privacy_policy_text_en',
        'privacy_policy_link_ru',
        'privacy_policy_link_kk',
        'privacy_policy_link_en',

        'cookie_policy_text_ru',
        'cookie_policy_text_kk',
        'cookie_policy_text_en',
        'cookie_policy_link_ru',
        'cookie_policy_link_kk',
        'cookie_policy_link_en',
    ];
}
