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
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Bavix\Wallet\Traits\HasWalletFloat;
use Bavix\Wallet\Interfaces\WalletFloat;



class User extends Authenticatable implements Wallet, WalletFloat
{
    use HasFactory, Notifiable, HasRoles, HasWallet, HasApiTokens, HasWalletFloat;
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
        'country',
        'national_id',
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
        return $this->hasOne(Driver::class);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
    public function guardian()
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


    public function scopeWhereEmailOrPhone($query, string $value)
    {
        return $query->where('email', $value)->orWhere('phone', $value);
    }


    public function assignRoleAndPermissions(RoleEnum $role): void
    {
        $roleModel = Role::where('name', $role->value)->firstOrFail();

        $this->assignRole($roleModel);
        $this->syncPermissions($roleModel->permissions);
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }


    public function teacherLessons()
    {
        return $this->hasMany(Lesson::class, 'teacher_id');
    }

    public function driverLessons()
    {
        return $this->hasMany(Lesson::class, 'driver_id');
    }

    public function studentLessons()
    {
        return $this->hasMany(Lesson::class, 'student_id');
    }
    public function todayLessons()
    {
        return $this->lessonsByRole()
            ->today()
            ->ordered();
    }

    public function thisWeekLessons()
    {
        return $this->lessonsByRole()
            ->betweenDates(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek())
            ->ordered();
    }

    public function thisMonthLessons()
    {
        return $this->lessonsByRole()
            ->whereMonth('lesson_date', Carbon::now()->month)
            ->ordered();
    }

    public function activeLessons()
    {
        return $this->lessonsByRole()
            ->where('is_active', true);
    }

    public function upcomingLessons()
    {
        return $this->lessonsByRole()
            ->upcoming()
            ->ordered()
        ;
    }

    public function ongoingLessons()
    {
        return $this->lessonsByRole()->ongoing()
            ->ordered();
    }

    public function tomorrowLessons()
    {
        return $this->lessonsByRole()
            ->whereDate('lesson_date', Carbon::tomorrow())
            ->ordered();
    }
    public function lessonsByRole()
    {
        if ($this->hasRole(RoleEnum::ADMIN->value)) {
            return Lesson::query();
        }

        if ($this->hasRole(RoleEnum::TEACHER->value)) {
            return Lesson::where('teacher_id', $this->id);
        }

        if ($this->hasRole(RoleEnum::DRIVER->value)) {
            return Lesson::where('driver_id', $this->id);
        }

        if ($this->hasRole(RoleEnum::PARENT->value)) {
            $studentIds = $this->guardian->students->pluck('id') ?? [];
            return Lesson::whereIn('student_id', $studentIds);
        }

        return Lesson::whereRaw('0 = 1');
    }

    // protected static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->created_by = auth()->check() ? auth()->id() : 1;
    //         $model->updated_by = auth()->check() ? auth()->id() : 1;
    //     });

    //     static::updating(function ($model) {
    //         $model->updated_by = auth()->check() ? auth()->id() : 1;
    //     });
    // }
}
