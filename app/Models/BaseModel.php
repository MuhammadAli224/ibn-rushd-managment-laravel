<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class BaseModel extends Model
{
    /**
     * The attributes that should be mass assignable.
     *
     * @var list<string>
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->created_by = auth()->check() ? auth()->id() : 1;
            $model->updated_by = auth()->check() ? auth()->id() : 1;
           
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->check() ? auth()->id() : 1;
        });
    }
}
