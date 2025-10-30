<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'title_en',
        'title_ru',
        'title_kk',
        'phone_placeholder_en',
        'phone_placeholder_ru',
        'phone_placeholder_kk',
        'name_placeholder_en',
        'name_placeholder_ru',
        'name_placeholder_kk',
        'message_placeholder_en',
        'message_placeholder_ru',
        'message_placeholder_kk',
        'btn_text_en',
        'btn_text_ru',
        'btn_text_kk',
        'note_text_en',
        'note_text_ru',
        'note_text_kk',
        'contact_info_text_en',
        'contact_info_text_ru',
        'contact_info_text_kk',

    ];
}
