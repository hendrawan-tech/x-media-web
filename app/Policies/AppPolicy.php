<?php

namespace App\Policies;

use App\Models\App;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AppPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the app can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list apps');
    }

    /**
     * Determine whether the app can view the model.
     */
    public function view(User $user, App $model): bool
    {
        return $user->hasPermissionTo('view apps');
    }

    /**
     * Determine whether the app can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create apps');
    }

    /**
     * Determine whether the app can update the model.
     */
    public function update(User $user, App $model): bool
    {
        return $user->hasPermissionTo('update apps');
    }

    /**
     * Determine whether the app can delete the model.
     */
    public function delete(User $user, App $model): bool
    {
        return $user->hasPermissionTo('delete apps');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete apps');
    }

    /**
     * Determine whether the app can restore the model.
     */
    public function restore(User $user, App $model): bool
    {
        return false;
    }

    /**
     * Determine whether the app can permanently delete the model.
     */
    public function forceDelete(User $user, App $model): bool
    {
        return false;
    }
}
