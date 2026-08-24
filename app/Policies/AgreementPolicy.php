<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Agreement;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Agreement');
    }

    public function view(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('View:Agreement');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Agreement');
    }

    public function update(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('Update:Agreement');
    }

    public function delete(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('Delete:Agreement');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Agreement');
    }

    public function restore(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('Restore:Agreement');
    }

    public function forceDelete(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('ForceDelete:Agreement');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Agreement');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Agreement');
    }

    public function replicate(AuthUser $authUser, Agreement $agreement): bool
    {
        return $authUser->can('Replicate:Agreement');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Agreement');
    }

}