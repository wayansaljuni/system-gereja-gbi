<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Teknisi;
use Illuminate\Auth\Access\HandlesAuthorization;

class TeknisiPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Teknisi');
    }

    public function view(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('View:Teknisi');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Teknisi');
    }

    public function update(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('Update:Teknisi');
    }

    public function delete(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('Delete:Teknisi');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:Teknisi');
    }

    public function restore(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('Restore:Teknisi');
    }

    public function forceDelete(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('ForceDelete:Teknisi');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:Teknisi');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:Teknisi');
    }

    public function replicate(AuthUser $authUser, Teknisi $teknisi): bool
    {
        return $authUser->can('Replicate:Teknisi');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:Teknisi');
    }

}