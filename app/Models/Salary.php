<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
    use HasFactory;

    protected $fillable = [
        'salaryable_id',
        'salaryable_type',
        'amount',
        'type',
        'salary_date',
        'month',
        'is_paid',
        'payment_method',
        'transaction_id',
        'center_commission_value',
        'center_commission_percentage',
        'notes',
    ];

    public function salaryable()
    {
        return $this->morphTo();
    }
}
