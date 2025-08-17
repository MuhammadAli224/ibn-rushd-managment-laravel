<?php

namespace App\Policies;

use App\Enums\RoleEnum;
use App\Models\CenterEarning;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CenterEarningPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, CenterEarning $centerEarning): bool
    {
         return $user->hasRole( RoleEnum::ADMIN->value);
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
    public function update(User $user, CenterEarning $centerEarning): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CenterEarning $centerEarning): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, CenterEarning $centerEarning): bool
    {
         return $user->hasRole( RoleEnum::ADMIN->value);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, CenterEarning $centerEarning): bool
    {
        return $user->hasRole( RoleEnum::ADMIN->value);
    }
}
