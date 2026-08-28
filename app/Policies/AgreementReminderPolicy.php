<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AgreementReminder;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgreementReminderPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AgreementReminder');
    }

    public function view(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('View:AgreementReminder');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AgreementReminder');
    }

    public function update(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('Update:AgreementReminder');
    }

    public function delete(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('Delete:AgreementReminder');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('DeleteAny:AgreementReminder');
    }

    public function restore(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('Restore:AgreementReminder');
    }

    public function forceDelete(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('ForceDelete:AgreementReminder');
    }

    public function forceDeleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('ForceDeleteAny:AgreementReminder');
    }

    public function restoreAny(AuthUser $authUser): bool
    {
        return $authUser->can('RestoreAny:AgreementReminder');
    }

    public function replicate(AuthUser $authUser, AgreementReminder $agreementReminder): bool
    {
        return $authUser->can('Replicate:AgreementReminder');
    }

    public function reorder(AuthUser $authUser): bool
    {
        return $authUser->can('Reorder:AgreementReminder');
    }

}