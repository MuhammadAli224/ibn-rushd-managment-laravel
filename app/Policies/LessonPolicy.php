<?php

namespace App\Policies;

use App\Models\Lesson;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class LessonPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Lesson $lesson): bool
    {
        if ($user->hasRole(App\Enums\RoleEnum::Admin->value)) {
            return true;
        }

        if ($user->hasRole(App\Enums\RoleEnum::Teacher->value) && $user->id === $lesson->teacher->user_id) {
            return true;
        }

        if ($user->hasRole(App\Enums\RoleEnum::Student->value) && $user->id === $lesson->student->guardian->user_id) {
            return true;
        }

        if ($user->hasRole(App\Enums\RoleEnum::Parent->value) && $user->id === $lesson->guardian->user_id) {
            return true;
        }

        if ($user->hasRole(App\Enums\RoleEnum::Driver->value) && $user->id === $lesson->driver->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::Admin->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        if ($user->hasRole(App\Enums\RoleEnum::Admin->value)) {
            return true;
        }
        return $user->hasRole(App\Enums\RoleEnum::Teacher->value) && $user->id === $lesson->teacher->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(App\Enums\RoleEnum::Admin->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(App\Enums\RoleEnum::Admin->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(App\Enums\RoleEnum::Admin->value);
    }
}
