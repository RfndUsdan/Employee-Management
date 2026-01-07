<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use App\Models\User;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Hash;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // Ambil password langsung dari "state" form, bukan dari $data
        $rawState = $this->form->getRawState();
        $password = $rawState['password'] ?? null;

        if (!$password) {
            throw new \Exception("Password wajib diisi untuk membuat akun login.");
        }

        // 1. Buat User baru di tabel users
        $user = \App\Models\User::create([
            'name' => $data['full_name'],
            'email' => $data['email'],
            'password' => \Illuminate\Support\Facades\Hash::make($password),
            'role' => 'employee', // Tegaskan sebagai employee
        ]);

        // 2. Hubungkan ke employee
        $data['user_id'] = $user->id;

        return $data;
    }
}