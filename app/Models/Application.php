<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    public function details()
    {
        return $this->hasOne(ApplicantDetail::class);
    }
}
