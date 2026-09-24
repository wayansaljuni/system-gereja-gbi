<?php

namespace App\Imports;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    public function model(array $row): ?Model
    {
        $email = trim($row['email']);

        $user = User::where('email', $email)->first();

        if ($user) {
            // User sudah ada → update data saja
            // Password tidak diubah
            $user->update([
                'name' => trim($row['name']),
                'nik' => trim((string) ($row['nik'] ?? '')),
                'kdun' => trim((string) ($row['kdun'] ?? '')),
                'kdcab' => trim((string) ($row['kdcab'] ?? '')),
            ]);
        } else {
            // User baru
            $user = User::create([
                'name' => trim($row['name']),
                'email' => $email,
                'nik' => trim((string) ($row['nik'] ?? '')),
                'kdun' => trim((string) ($row['kdun'] ?? '')),
                'kdcab' => trim((string) ($row['kdcab'] ?? '')),

                // Default password
                'password' => Hash::make('password'),

                // Wajib ganti password
                'must_change_password' => 1,
            ]);
        }

        // Semua user dari Excel menjadi role teknisi
        $user->syncRoles(['teknisi']);

        return $user;
    }

    public function rules(): array
    {
        return [
            '*.name' => ['required'],
            '*.email' => ['required', 'email'],
            '*.nik' => ['nullable'],
            '*.kdun' => ['nullable'],
            '*.kdcab' => ['nullable'],
        ];
    }
}