<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drivers extends BaseModel
{
    protected $fillable = [
        'name',
        "center_id",
        'phone',
        'email',
        'address',
        "national_id",
        "license_number",
        "vehicle_type",
        "vehicle_number",
        "experience",
        "status",
        "profile_picture",
        "password",
        "remember_token",
        "is_active",
        'created_by',
        'updated_by',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    public function center()
    {
        return $this->belongsTo(Center::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }
}
