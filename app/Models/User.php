<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
// use Database\Factories\UserFactory;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
// use Illuminate\Notifications\Notifiable;
// use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements FilamentUser
{
    use HasRoles;

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }
    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'must_change_password',
        'kd_cab',
        'kdun',
        'nik',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'must_change_password' => 'boolean',
        ];
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
            'approvalpr',
        ]);
    }

    public function hasAnyRoleCustom(array $roles): bool
    {
        return $this->hasAnyRole($roles);
    }

    public function getCabang(): ?Kdcab
    {
        if (blank($this->kd_cab)) {
            return null;
        }

        return Kdcab::query()
            ->where('kd_cab', $this->kd_cab)
            ->first();
    }
    
    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Mkar::class, 'nik', 'nik');
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Munit::class, 'kdun', 'kdun');
    }
}
