<?php

namespace App\Policies;

use App\Models\Hpo;
use App\Models\User;

class HpoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'approvepo']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Hpo $hpo): bool
    {
        return $user->hasAnyRole(['super_admin', 'approvepo']);
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
    public function update(User $user, Hpo $hpo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Hpo $hpo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Hpo $hpo): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Hpo $hpo): bool
    {
        return false;
    }
    public function approve(User $user, Hpo $hpo): bool
    {
        return $user->hasAnyRole(['super_admin', 'approvepo'])
            && $hpo->approve !== 'Y';
    }
}
