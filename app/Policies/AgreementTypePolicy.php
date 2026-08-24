<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AgreementType;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementTypePolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AgreementType');
    }

    public function view(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('View:AgreementType');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AgreementType');
    }

    public function update(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('Update:AgreementType');
    }

    public function delete(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('Delete:AgreementType');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AgreementType');
    }

    public function restore(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('Restore:AgreementType');
    }

    public function forceDelete(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('ForceDelete:AgreementType');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AgreementType');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AgreementType');
    }

    public function replicate(AuthUser $authUser, AgreementType $agreementType): bool
    {
        return $authUser->can('Replicate:AgreementType');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AgreementType');
    }

}