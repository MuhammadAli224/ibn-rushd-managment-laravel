<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Driver extends BaseModel
{
    protected $fillable = [
        'user_id',
        "center_id",
        "attachment",
        "license_number",
        "vehicle_type",
        "vehicle_number",
        "created_by",
        "updated_by"
    ];

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
