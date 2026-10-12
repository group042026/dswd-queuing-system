<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InitialAdminSignupTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_open_setup_page_even_if_an_admin_exists(): void
    {
        $admin = $this->createAdmin('existing-admin@example.com', 'existing-admin');

        $this->actingAs($admin)
            ->get(route('hidden-signup'))
            ->assertOk()
            ->assertSee('Create an admin account');
    }

    public function test_admin_can_create_an_additional_admin(): void
    {
        $admin = $this->createAdmin('existing-admin@example.com', 'existing-admin');

        $this->actingAs($admin)
            ->post(route('hidden-signup.store'), [
            'first_name' => 'Admin',
            'middle_name' => '',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'username' => 'admin-user',
            'password' => 'Very-Strong-Password-123!',
            'password_confirmation' => 'Very-Strong-Password-123!',
        ])->assertRedirect(route('admin.users.list'));

        $user = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $role = Role::query()->where('role_name', 'admin')->firstOrFail();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->assertDatabaseCount('users', 2);
    }

    public function test_guest_cannot_open_or_submit_the_admin_signup_page(): void
    {
        $this->get(route('hidden-signup'))
            ->assertRedirect(route('login'));

        $this->post(route('hidden-signup.store'))
            ->assertRedirect(route('login'));
    }

    public function test_non_admin_user_cannot_open_or_submit_the_admin_signup_page(): void
    {
        $user = $this->createUser('user@example.com', 'ordinary-user');

        $this->actingAs($user)
            ->get(route('hidden-signup'))
            ->assertForbidden();

        $this->post(route('hidden-signup.store'))
            ->assertForbidden();

        $this->assertDatabaseCount('users', 1);
    }

    private function createAdmin(string $email, string $username): User
    {
        $role = Role::query()->firstOrCreate(['role_name' => 'admin']);

        $user = $this->createUser($email, $username);
        $user->roles()->attach($role->id);

        return $user;
    }

    private function createUser(string $email, string $username): User
    {
        return User::query()->create([
            'first_name' => 'Existing',
            'last_name' => 'Admin',
            'email' => $email,
            'username' => $username,
            'password' => 'Existing-Password-123!',
            'status' => 'active',
        ]);
    }
}
