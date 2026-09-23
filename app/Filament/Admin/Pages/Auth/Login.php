<?php

namespace App\Filament\Admin\Pages\Auth;

use App\Models\User;
use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function authenticate(): ?LoginResponse
    {
        $data = $this->form->getState();

        // Cari user berdasarkan email yang dimasukkan
        $user = User::where('email', $data['email'])->first();
        //  dd($user->hasRole('superadmin'));
        // Superadmin dilewati dari pengecekan mkar
        // dd($user?->nik);

        // $karyawan = DB::connection('mysql55')
        //     ->table('mkar')
        //     ->where('nik', $user->nik)
        //     ->first();
        
        if ($user && ! $user->hasRole('superadmin') && !is_null($user->nik)) {
            $isResigned = DB::connection('mysql55')
                ->table('mkar')
                ->where('nik', $user->nik)
                ->first();
            if ($isResigned->tglklr !== '0000-00-00' && !is_null($isResigned->tglklr)) {
                throw ValidationException::withMessages([
                    'data.email' => 'Akun sudah tidak aktif karena karyawan sudah keluar dari perusahaan.',
                ]);
            }
        }
        return parent::authenticate();
    }
}