<?php

namespace App\Policies;

use App\Enums\RoleEnum;
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
        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return true;
        }

        if ($user->hasRole(RoleEnum::TEACHER->value) && $user->id === $lesson->teacher->user_id) {
            return true;
        }

        if ($user->hasRole(RoleEnum::STUDENT->value) && $user->id === $lesson->student->guardian->user_id) {
            return true;
        }

        if ($user->hasRole(RoleEnum::PARENT->value) && $user->id === $lesson->guardian->user_id) {
            return true;
        }

        if ($user->hasRole(RoleEnum::DRIVER->value) && $user->id === $lesson->driver->user_id) {
            return true;
        }

        return false;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Lesson $lesson): bool
    {
        if ($user->hasRole(RoleEnum::ADMIN->value)) {
            return true;
        }
        return $user->hasRole( RoleEnum::TEACHER->value) && $user->id === $lesson->teacher->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Lesson $lesson): bool
    {
        return $user->hasRole(RoleEnum::ADMIN->value);
    }
}
