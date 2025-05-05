<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Subject extends BaseModel
{
    use HasTranslations;
    public $translatable = ['name', 'description'];

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
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'subject_teacher', 'subject_id', 'teacher_id');
    }
}
