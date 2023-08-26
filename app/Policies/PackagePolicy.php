<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the package can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list packages');
    }

    /**
     * Determine whether the package can view the model.
     */
    public function view(User $user, Package $model): bool
    {
        return $user->hasPermissionTo('view packages');
    }

    /**
     * Determine whether the package can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create packages');
    }

    /**
     * Determine whether the package can update the model.
     */
    public function update(User $user, Package $model): bool
    {
        return $user->hasPermissionTo('update packages');
    }

    /**
     * Determine whether the package can delete the model.
     */
    public function delete(User $user, Package $model): bool
    {
        return $user->hasPermissionTo('delete packages');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete packages');
    }

    /**
     * Determine whether the package can restore the model.
     */
    public function restore(User $user, Package $model): bool
    {
        return false;
    }

    /**
     * Determine whether the package can permanently delete the model.
     */
    public function forceDelete(User $user, Package $model): bool
    {
        return false;
    }
}
