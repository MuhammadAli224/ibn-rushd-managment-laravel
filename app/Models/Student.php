<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends BaseModel
{
    protected $fillable = [
        'name',
        'center_id',
        'phone',
        'address',
        'is_active',
        'created_by',
        'updated_by',
    ];
  

    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
