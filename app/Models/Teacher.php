<?php


namespace App\Models;

use App\Models\BaseModel;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWalletFloat;


class Teacher extends BaseModel implements Wallet
{
    use HasWalletFloat;
    protected $fillable = [
        'user_id',
        'date_of_birth',
        'qualification',
        'specialization',
        'experience',
        'commission',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'qualification' => \App\Enums\QualificationEnum::class,

    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function scopeSpecialization($query, $specialization)
    {
        return $query->where('specialization', 'like', "%$specialization%");
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }


    public function balances()
    {
        return $this->morphMany(Balance::class, 'balanceable');
    }

    public function salaries()
    {
        return $this->morphMany(Salary::class, 'salaryable');
    }
}
