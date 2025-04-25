<?php

namespace App\Models;

use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends BaseModel implements Wallet
{
    use HasWallet,
        HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'national_id',
        'gender',
        'date_of_birth',
        'qualification',
        'specialization',
        'experience',
        'status',
        'profile_picture',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'email_verified_at' => 'datetime',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
    public function scopeInactive($query)
    {
        return $query->where('status', 'inactive');
    }
    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%")
                ->orWhere('address', 'like', "%$search%");
        });
    }

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}



// use Bavix\Wallet\Models\Transaction;

// // After a lesson is completed
// $lessonPrice = $lesson->lesson_price;
// $commissionRate = ($totalIncome >= 10000) ? 0.5 : 0.4;  // 50% if earnings > 10k
// $teacherCommission = $lessonPrice * $commissionRate;

// // Deposit the commission into the teacher's wallet
// $teacher->deposit($teacherCommission, [
//     'type' => 'lesson',
//     'lesson_id' => $lesson->id,
//     'commission_rate' => $commissionRate,
// ]);

// // Log the transaction
// Transaction::create([
//     'wallet_id' => $teacher->wallet->id,
//     'amount' => $teacherCommission,
//     'transaction_type' => 'deposit',
//     'details' => "Commission for lesson ID: {$lesson->id}",
// ]);


// // End of month salary calculation
// $teacherWalletBalance = $teacher->wallet->balance;  // Current balance

// // Calculate teacher's final salary (you can aggregate based on lessons completed)
// $teacherSalary = $teacher->wallet->balance;

// // Allow the teacher to withdraw the salary to their bank account
// $teacher->withdraw($teacherSalary, [
//     'type' => 'salary',
//     'details' => 'End of month salary withdrawal',
// ]);

// // Record the withdrawal transaction
// Transaction::create([
//     'wallet_id' => $teacher->wallet->id,
//     'amount' => $teacherSalary,
//     'transaction_type' => 'withdrawal',
//     'details' => 'Salary withdrawal',
// ]);
