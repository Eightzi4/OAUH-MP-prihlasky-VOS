<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantDetail extends Model
{
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
        'nia_data' => 'array',
        'verified_fields' => 'array',
    ];
}
