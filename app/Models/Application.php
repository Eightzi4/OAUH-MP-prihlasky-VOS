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

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function attachments()
    {
        return $this->hasMany(ApplicationAttachment::class);
    }
}
