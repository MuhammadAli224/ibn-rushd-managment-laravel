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
        'center_id',
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
        'commission_rate',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => LessonStatusEnum::class,
        'lesson_date' => 'date',
        'lesson_start_time' => 'datetime:H:i',
        'lesson_end_time' => 'datetime:H:i',
        'check_in_time' => 'datetime:H:i',
        'check_out_time' => 'datetime:H:i',
        'is_active' => 'boolean',
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
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereDate('lesson_date', '>=', now())->orderBy('lesson_date');
    }

    public function scopePast($query)
    {
        return $query->whereDate('lesson_date', '<', now())->orderByDesc('lesson_date');
    }

    public function scopeToday($query)
    {
        return $query->whereDate('lesson_date', today());
    }

    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    public function scopeForStudent($query, $studentId)
    {
        return $query->where('student_id', $studentId);
    }

    public function scopeForDriver($query, $driverId)
    {
        return $query->where('driver_id', $driverId);
    }

    public function scopeForCenter($query, $centerId)
    {
        return $query->where('center_id', $centerId);
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeBetweenDates($query, $from, $to)
    {
        return $query->whereBetween('lesson_date', [$from, $to]);
    }

    public function scopeWithRelations($query)
    {
        return $query->with(['teacher', 'student', 'driver', 'subject', 'creator', 'updater']);
    }

    public function scopeByCreator($query, $userId)
    {
        return $query->where('created_by', $userId);
    }
}
