<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Hpr;
use Illuminate\Auth\Access\HandlesAuthorization;

class HprPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $user): bool
    {
        return $user->hasAnyRole(['super_admin', 'approvepr']);
    }


    public function view(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('View:Hpr');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Hpr');
    }

    public function update(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('Update:Hpr');
    }

    public function delete(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('Delete:Hpr');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Hpr');
    }

    public function restore(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('Restore:Hpr');
    }

    public function forceDelete(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('ForceDelete:Hpr');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Hpr');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Hpr');
    }

    public function replicate(AuthUser $authUser, Hpr $hpr): bool
    {
        return $authUser->can('Replicate:Hpr');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Hpr');
    }

}