<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserRoleSelectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_add_and_edit_forms_show_the_fixed_role_options(): void
    {
        $admin = $this->createUser('admin@example.com', 'admin-user');
        $this->assignRole($admin, 'admin');
        $user = $this->createUser('receptionist@example.com', 'receptionist-user');
        $this->assignRole($user, 'receptionist');

        $response = $this->actingAs($admin)->get(route('admin.users.list'));

        $response->assertOk();

        foreach (['admin', 'receptionist', 'social worker', 'approving officer', 'paymaster'] as $roleName) {
            $response->assertSee('value="'.$roleName.'"', false);
        }

        $this->assertDatabaseCount('roles', 2);
    }

    public function test_admin_can_create_user_with_a_role_missing_from_database(): void
    {
        $admin = $this->createUser('admin@example.com', 'admin-user');
        $this->assignRole($admin, 'admin');

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'first_name' => 'Social',
                'middle_name' => 'Worker',
                'last_name' => 'User',
                'email' => 'social.worker@example.com',
                'username' => 'social-worker',
                'password' => 'Strong-Password-123!',
                'password_confirmation' => 'Strong-Password-123!',
                'license_number' => 'LIC12345',
                'role' => 'social worker',
                'contact_number' => '09123456789',
                'status' => 'active',
            ])
            ->assertRedirect(route('admin.users.list'));

        $user = User::query()->where('email', 'social.worker@example.com')->firstOrFail();
        $role = Role::query()->where('role_name', 'social worker')->firstOrFail();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);
    }

    public function test_admin_can_update_a_users_role_by_name(): void
    {
        $admin = $this->createUser('admin@example.com', 'admin-user');
        $this->assignRole($admin, 'admin');
        $user = $this->createUser('operator@example.com', 'operator-user');
        $this->assignRole($user, 'receptionist');

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'first_name' => 'Updated',
                'middle_name' => 'User',
                'last_name' => 'Name',
                'email' => $user->email,
                'username' => $user->username,
                'license_number' => 'LIC54321',
                'contact_number' => '09123456789',
                'status' => 'active',
                'role' => 'paymaster',
            ])
            ->assertRedirect(route('admin.users.list'));

        $paymaster = Role::query()->where('role_name', 'paymaster')->firstOrFail();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $paymaster->id,
        ]);
        $this->assertDatabaseMissing('role_user', [
            'user_id' => $user->id,
            'role_id' => Role::query()->where('role_name', 'receptionist')->value('id'),
        ]);
    }

    private function createUser(string $email, string $username): User
    {
        return User::query()->create([
            'first_name' => 'Test',
            'middle_name' => 'User',
            'last_name' => 'Account',
            'email' => $email,
            'username' => $username,
            'password' => 'Strong-Password-123!',
            'status' => 'active',
        ]);
    }

    private function assignRole(User $user, string $roleName): void
    {
        $role = Role::query()->firstOrCreate(['role_name' => $roleName]);
        $user->roles()->attach($role->id);
    }
}
