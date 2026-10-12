<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class InitialAdminSignupTest extends TestCase
{
    use RefreshDatabase;

    public function test_setup_page_is_available_when_configured_and_no_admin_exists(): void
    {
        config(['services.initial_admin_setup_token' => 'one-time-test-secret']);

        $this->get(route('hidden-signup'))
            ->assertOk()
            ->assertSee('Create the first admin');
    }

    public function test_valid_setup_secret_creates_the_first_admin_and_closes_setup(): void
    {
        config(['services.initial_admin_setup_token' => 'one-time-test-secret']);

        $this->post(route('hidden-signup.store'), [
            'setup_token' => 'one-time-test-secret',
            'first_name' => 'Admin',
            'middle_name' => '',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'username' => 'admin-user',
            'password' => 'Very-Strong-Password-123!',
            'password_confirmation' => 'Very-Strong-Password-123!',
        ])->assertRedirect(route('login'));

        $user = User::query()->where('email', 'admin@example.com')->firstOrFail();
        $role = Role::query()->where('role_name', 'admin')->firstOrFail();

        $this->assertDatabaseHas('role_user', [
            'user_id' => $user->id,
            'role_id' => $role->id,
        ]);

        $this->get(route('hidden-signup'))->assertNotFound();
    }

    public function test_invalid_setup_secret_does_not_create_an_admin(): void
    {
        config(['services.initial_admin_setup_token' => 'one-time-test-secret']);

        $this->post(route('hidden-signup.store'), [
            'setup_token' => 'wrong-secret',
        ])->assertForbidden();

        $this->assertDatabaseCount('users', 0);
    }

    public function test_setup_page_is_hidden_when_no_secret_is_configured(): void
    {
        config(['services.initial_admin_setup_token' => null]);

        $this->get(route('hidden-signup'))->assertNotFound();
    }
}
