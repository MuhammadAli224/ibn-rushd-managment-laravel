<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends BaseModel
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'driver_id',
        'student_id',
        'lesson_date',
        'lesson_start_time',
        'lesson_end_time',
        'lesson_location',
        'lesson_notes',
        'status',
        'lesson_duration',
        'check_in_time',
        'check_out_time',
        'uber_charge',
        'lesson_price',
        'is_active',
        'created_by',
        'updated_by',
        'commission_rate',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }


    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
