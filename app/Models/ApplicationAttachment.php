<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicationAttachment extends Model
{
    protected $guarded = [];

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
