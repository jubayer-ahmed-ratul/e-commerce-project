<?php

namespace App\Filament\Resources\CustomersResource\Pages;

use App\Filament\Resources\CustomersResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;

class EditCustomers extends EditRecord
{
    protected static string $resource = CustomersResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        // Remove password if checkbox not checked
        if (empty($data['create_user'])) {
            unset($data['password']);
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $customer = $this->record;

        // If the checkbox is checked
        if ($this->data['create_user']) {
            // If this customer already has a user, update the password if provided
            if ($customer->user) {
                if (!empty($this->data['password'])) {
                    $customer->user->update([
                        'password' => Hash::make($this->data['password']),
                    ]);
                }
            } else {
                // Otherwise, create a new user account
                $user = User::create([
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'password' => Hash::make($this->data['password']),
                    'user_type_id' => UserType::where('name', 'Customer')->first()?->id, // adjust as needed
                ]);

                $customer->update(['user_id' => $user->id]);
            }
        }
    }
}
