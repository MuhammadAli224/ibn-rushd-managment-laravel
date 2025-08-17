<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterEarning extends Model
{
    protected $fillable = [
        'center_id',
        'amount',
        'source',
        'earning_date',
    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
