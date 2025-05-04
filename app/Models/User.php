<?php

namespace App\Models;

use App\Enums\GenderEnum;
use App\Enums\RoleEnum;
use App\Enums\StatusEnum;
use Bavix\Wallet\Interfaces\Wallet;
use Bavix\Wallet\Traits\HasWallet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Wallet
{
    use HasFactory, Notifiable, HasRoles, HasWallet;
    // public function canAccessPanel(Panel $panel): bool
    // {
    //     return  $this->hasRole(RoleEnum::ADMIN);
    // }
    protected $fillable = [
        'name',
        'email',
        'password',
        'phone',
        'address',
        'fcm_token',
        'is_active',
        'created_by',
        'updated_by',
        'image',
        'status',
        'gender',
        'center_id',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'main_role' => 'string',
            'is_active' => 'boolean',
            'status' => StatusEnum::class,
            'gender' => GenderEnum::class,
            'created_by' => User::class,
            'updated_by' => User::class,
        ];
    }


    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function teacher()
    {
        return $this->hasOne(Teacher::class);
    }

    public function driver()
    {
        return $this->hasOne(Drivers::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function gurdian()
    {
        return $this->hasOne(Guardian::class);
    }
    public function center()

    {
        return $this->belongsTo(Center::class);
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher', 'teacher_id', 'subject_id');
    }
    // protected static function booted()
    // {
    //     static::creating(function ($model) {
    //         if (Auth::check()) {
    //             $model->created_by = Auth::id();
    //             $model->updated_by = Auth::id();
    //         }
    //     });

    //     static::updating(function ($model) {
    //         if (Auth::check()) {
    //             $model->updated_by = Auth::id();
    //         }
    //     });
    // }
}
