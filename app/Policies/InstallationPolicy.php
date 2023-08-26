<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Installation;
use Illuminate\Auth\Access\HandlesAuthorization;

class InstallationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the installation can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list installations');
    }

    /**
     * Determine whether the installation can view the model.
     */
    public function view(User $user, Installation $model): bool
    {
        return $user->hasPermissionTo('view installations');
    }

    /**
     * Determine whether the installation can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create installations');
    }

    /**
     * Determine whether the installation can update the model.
     */
    public function update(User $user, Installation $model): bool
    {
        return $user->hasPermissionTo('update installations');
    }

    /**
     * Determine whether the installation can delete the model.
     */
    public function delete(User $user, Installation $model): bool
    {
        return $user->hasPermissionTo('delete installations');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete installations');
    }

    /**
     * Determine whether the installation can restore the model.
     */
    public function restore(User $user, Installation $model): bool
    {
        return false;
    }

    /**
     * Determine whether the installation can permanently delete the model.
     */
    public function forceDelete(User $user, Installation $model): bool
    {
        return false;
    }
}
