<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use RuntimeException;

class InitialAdminSeeder extends Seeder
{
    public function run(): void
    {
        $email = config('services.initial_admin.email');
        $password = config('services.initial_admin.password');

        if (blank($email) || blank($password)) {
            throw new RuntimeException('Set INITIAL_ADMIN_EMAIL and INITIAL_ADMIN_PASSWORD first.');
        }

        $role = Role::firstOrCreate(['role_name' => 'admin']);

        $user = User::firstOrCreate(
            ['email' => $email],
            [
                'first_name' => env('INITIAL_ADMIN_FIRST_NAME', 'System'),
                'middle_name' => null,
                'last_name' => env('INITIAL_ADMIN_LAST_NAME', 'Administrator'),
                'username' => env('INITIAL_ADMIN_USERNAME', 'initial-admin'),
                'password' => Hash::make($password),
                'status' => 'active',
            ],
        );

        $user->roles()->syncWithoutDetaching([$role->id]);
    }
}
