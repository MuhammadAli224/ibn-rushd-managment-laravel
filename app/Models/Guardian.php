<?php

namespace App\Models;


class Guardian extends BaseModel
{
    // protected $table='guardian';
    protected $fillable = [
        'occupation',
        'whatsapp',
        "user_id",
        'created_by',
        'updated_by',
    ];

    public function students()
    {
        return $this->hasMany(Student::class, 'guardian_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
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
