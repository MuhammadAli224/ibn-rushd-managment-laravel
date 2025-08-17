<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    protected $fillable = [
        'user_id',
        'amount',
        'month',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function scopeThisMonth(Builder $query, ?string $month = null): Builder
    {
        $month = $month ?? Carbon::now()->format('Y-m');
        return $query->where('month', $month);
    }
}
