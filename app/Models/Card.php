<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    //
    protected $fillable = [
        'id',
        'name',
        'company',
        'company_logo',
        'company_type',
        'qr_code',
        'user_id',
        'approve_status',
        'approve_date',
        'approve_by',
        'duration_in_years',
        'message',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'dob' => 'datetime',
        'approve_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
