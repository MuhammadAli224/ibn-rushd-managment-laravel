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
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function driver()
    {
        return $this->belongsTo(Drivers::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    
}
