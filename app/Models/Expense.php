<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends BaseModel
{
    protected $fillable = [
        'center_id',
        'amount',
        'description',
        'date',
        'expense_category_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'date' => 'date',
    ];

   

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function expenseCategory()
    {
        return $this->belongsTo(ExpenseCategory::class, 'expense_category_id');
    }
    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function scopeToday($query)
    {
        return $query->whereDate('date', now());
    }
    public function scopeThisMonth($query)
    {
        return $query->whereMonth('date', now()->month);
    }
    public function scopeThisYear($query)
    {
        return $query->whereYear('date', now()->year);
    }
    public function scopeLastMonth($query)
    {
        return $query->whereMonth('date', now()->subMonth()->month);
    }
    public function scopeLastYear($query)
    {
        return $query->whereYear('date', now()->subYear()->year);
    }
    public function scopeBetween($query, $startDate, $endDate)
    {
        return $query->whereBetween('date', [$startDate, $endDate]);
    }
}
