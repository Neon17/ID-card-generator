<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CardInfo extends Model
{
    //
    protected $fillable = [
        'id',
        'company_name',
        'company_logo',
        'company_type',
        'company_address',
        'card_type',
        'select_fields',
        'select_fields_type',
        'approve_by',
        'card_duration',
        'custom_message',
        'card_color',
        'card_background',
        'card_background_color',
        'card_background_image',
        'card_background_image_type',
        'card_background_image_url',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'card_duration' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

}