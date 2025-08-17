<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Salary extends Model
{
   
    protected $fillable = [
        'user_id',
        'amount',
        'type',
        'salary_date',
        'month',
        'is_paid',
        'payment_method',
        'transaction_id',
        'center_commession_percentage',
        'center_commession_value',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
