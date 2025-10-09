<?php

namespace App\Filament\Resources\CustomersResource\Pages;

use App\Filament\Resources\CustomersResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

use App\Models\User;
use App\Models\UserType;
use Illuminate\Support\Facades\Hash;

class CreateCustomers extends CreateRecord
{
    protected static string $resource = CustomersResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        // We’ll create the user after saving the customer
        return $data;
    }

    protected function afterCreate(): void
    {
        $customer = $this->record;

        if ($this->data['create_user']) {
            $user = User::create([
                'name' => $customer->name,
                'email' => $customer->email,
                'password' => Hash::make($this->data['password']),
                'user_types_id' => UserType::where('name', 'Customer')->first()?->id, // adjust as needed
            ]);

            $customer->update(['user_id' => $user->id]);
        }
    }
}