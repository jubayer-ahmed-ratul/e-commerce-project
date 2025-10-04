<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class CreateUser extends Command
{
    protected $signature = 'user:create'; // ✅ এই নাম দিয়ে কল করতে হবে
    protected $description = 'Create a new user interactively';

    public function handle()
    {
        $name = $this->ask('Enter name');
        $email = $this->ask('Enter email');
        $password = $this->secret('Enter password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => $password, // model এ hashed cast আছে
        ]);

        $this->info("✅ User created successfully: {$user->email}");
    }
}
