<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Model;

class Center extends Model implements Wallet
{
    use HasWallet;

    protected $fillable = [
        'name',
        'location',
        'email',
        'phone',
        'commission_ranges',
    ];

    protected $casts = [
        'commission_ranges' => 'array',
    ];
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
    public function earnings()
    {
        return $this->hasMany(CenterEarning::class);
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class);
    }
    public function drivers()
    {
        return $this->hasMany(Driver::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    // public function calculateTeacherCommission($totalEarnings)
    // {
    //     foreach ($this->commission_ranges as $range) {
    //         $min = $range['min'];
    //         $max = $range['max'];
    //         $percentage = $range['percentage'];

    //         if ($totalEarnings >= $min && ($totalEarnings <= $max || is_null($max))) {
    //             return ($totalEarnings * $percentage) / 100;
    //         }
    //     }

    //     return 0;
    // }

    public function calculateTeacherCommission($totalEarnings)
    {
        foreach ($this->commission_ranges as $range) {
            $min = $range['min'];
            $max = $range['max'];
            $percentage = $range['percentage'];

            if ($totalEarnings >= $min && ($totalEarnings <= $max || is_null($max))) {
                return ($totalEarnings * $percentage) / 100;
            }
        }
        return 0;
    }

    public function getTeacherCommission($totalEarnings)
    {
        return $this->calculateTeacherCommission($totalEarnings);
    }
    public function calculateCenterCommission($totalEarnings)
    {
        foreach ($this->commission_ranges as $range) {
            $min = $range['min'];
            $max = $range['max'];
            $percentage = $range['percentage'];

            if ($totalEarnings >= $min && ($totalEarnings <= $max || is_null($max))) {
                return  $percentage;
            }
        }
        return 0;
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class);
    }
    public function expenseCategories()
    {
        return $this->hasMany(ExpenseCategory::class);
    }
}
