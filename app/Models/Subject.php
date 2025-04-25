<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = [
        'name',
        'description',
        "center_id",
        'created_by',
        'updated_by',
    ];
    


    public function center()
    {
        return $this->belongsTo(Center::class);
    }
}
