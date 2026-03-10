<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
        'verified_fields' => 'array',
        'submitted_at' => 'datetime',
    ];

    public function studyProgram()
    {
        return $this->belongsTo(StudyProgram::class);
    }

    public function attachments()
    {
        return $this->hasMany(ApplicationAttachment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isStep1Complete(): bool
    {
        return !empty($this->first_name) &&
               !empty($this->last_name) &&
               !empty($this->gender) &&
               !empty($this->birth_number) &&
               !empty($this->birth_date) &&
               !empty($this->birth_city) &&
               !empty($this->citizenship) &&
               !empty($this->email) &&
               !empty($this->phone) &&
               !empty($this->street) &&
               !empty($this->city) &&
               !empty($this->zip) &&
               !empty($this->country);
    }

    public function isStep2Complete(): bool
    {
        $basicFilled = !empty($this->previous_school) &&
                       !empty($this->izo) &&
                       !empty($this->school_type) &&
                       !empty($this->previous_study_field) &&
                       !empty($this->previous_study_field_code);

        if (!$basicFilled) {
            return false;
        }

        $hasYear = !empty($this->graduation_year);
        $hasAvg = !empty($this->grade_average);
        $hasFile = $this->attachments()->where('type', 'maturita')->exists();

        if ($hasYear || $hasAvg || $hasFile) {
            return $hasYear && $hasAvg && $hasFile;
        }

        return true;
    }
}
