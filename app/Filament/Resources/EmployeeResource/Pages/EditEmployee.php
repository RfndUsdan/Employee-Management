<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class EditEmployee extends EditRecord
{
    protected static string $resource = EmployeeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $rawState = $this->form->getRawState();
        $password = $rawState['password'] ?? null;

        $employee = $this->getRecord();
        $user = \App\Models\User::find($employee->user_id);

        if ($user) {
            $userData = [
                'name' => $data['full_name'],
                'email' => $data['email'],
            ];

            // Update password hanya jika kotak password diisi
            if (filled($password)) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($password);
            }

            $user->update($userData);
        }

        return $data;
    }
}
