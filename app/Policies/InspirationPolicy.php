<?php

namespace App\Policies;

use App\Models\Inspiration;
use App\Models\User;

class InspirationPolicy
{
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('admin')) {
            return true;
        }

        return null;
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasRole('user');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Inspiration $inspiration): bool
    {
        return $user->hasRole('user');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Inspiration $inspiration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Inspiration $inspiration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Inspiration $inspiration): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Inspiration $inspiration): bool
    {
        return false;
    }
}
