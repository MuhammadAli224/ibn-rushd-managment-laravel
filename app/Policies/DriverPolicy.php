<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\Driver;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DriverPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value) ;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Driver $driver): bool
    {
       return $user->hasRole( RoleEnum::ADMIN->value) || $user->id === $driver->user_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
         return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Driver $driver): bool
    {
       return $user->hasRole( RoleEnum::ADMIN->value) || $user->id === $driver->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Driver $driver): bool
    {
      return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Driver $driver): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Driver $driver): bool
    {
         return $user->hasRole( RoleEnum::ADMIN->value);
    }
}
