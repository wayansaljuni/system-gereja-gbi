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

}