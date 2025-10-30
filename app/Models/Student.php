<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends BaseModel
{
    protected $fillable = [
        'name',
        'guardian_id',
        'class',
        "phone",
        "address",
        'created_by',
        'updated_by',
    ];



    public function guardian()
    {
        return $this->belongsTo(Guardian::class, 'guardian_id');
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'student_subject', 'student_id', 'subject_id');
    }
}
