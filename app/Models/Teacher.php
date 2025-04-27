<?php


namespace App\Models;

use App\Models\BaseModel;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\Notifiable;

class Teacher extends BaseModel
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'center_id',
        'user_id',
        'national_id',
        'date_of_birth',
        'qualification',
        'specialization',
        'experience',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
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
