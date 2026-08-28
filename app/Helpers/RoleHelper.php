<?php

namespace App\Helpers;

class RoleHelper
{
    public static function hasRole(string|array $roles): bool
    {
        $user = auth()->user();

        if (! $user) {
            return false;
        }

        return $user->hasAnyRole(
            is_array($roles) ? $roles : [$roles]
        );
    }

    public static function isSuperadmin(): bool
    {
        return self::hasRole('super_admin');
    }

    public static function isLegal(): bool
    {
        return self::hasRole('legal');
    }

    public static function isSuperadminOrLegal(): bool
    {
        return self::hasRole([
            'super_admin',
            'legal',
        ]);

    }

    public static function isApprovalpr(): bool
    {
        return self::hasRole([
            'super_admin',
            'approvalpr',
        ]);
    }
    public static function isSuperadminOrApprovalpr(): bool
    {
        return self::hasRole([
            'super_admin',
            'approvalpr',
        ]);
        
    }
}