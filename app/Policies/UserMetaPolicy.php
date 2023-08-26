<?php

namespace App\Policies;

use App\Models\User;
use App\Models\UserMeta;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserMetaPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the userMeta can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('list usermetas');
    }

    /**
     * Determine whether the userMeta can view the model.
     */
    public function view(User $user, UserMeta $model): bool
    {
        return $user->hasPermissionTo('view usermetas');
    }

    /**
     * Determine whether the userMeta can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasPermissionTo('create usermetas');
    }

    /**
     * Determine whether the userMeta can update the model.
     */
    public function update(User $user, UserMeta $model): bool
    {
        return $user->hasPermissionTo('update usermetas');
    }

    /**
     * Determine whether the userMeta can delete the model.
     */
    public function delete(User $user, UserMeta $model): bool
    {
        return $user->hasPermissionTo('delete usermetas');
    }

    /**
     * Determine whether the user can delete multiple instances of the model.
     */
    public function deleteAny(User $user): bool
    {
        return $user->hasPermissionTo('delete usermetas');
    }

    /**
     * Determine whether the userMeta can restore the model.
     */
    public function restore(User $user, UserMeta $model): bool
    {
        return false;
    }

    /**
     * Determine whether the userMeta can permanently delete the model.
     */
    public function forceDelete(User $user, UserMeta $model): bool
    {
        return false;
    }
}
