<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends BaseModel
{
    protected $fillable = [
        'user_id',
        "center_id",
        "national_id",
        "license_number",
        "vehicle_type",
        "vehicle_number",
    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
