<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class InitialAdminSignupController extends Controller
{
    public function create(): View
    {
        abort_unless($this->setupIsAvailable(), 404);

        return view('auth.hidden-signup');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($this->setupIsAvailable(), 404);

        $setupToken = config('services.initial_admin_setup_token');

        abort_unless(
            is_string($setupToken)
                && $setupToken !== ''
                && hash_equals($setupToken, (string) $request->input('setup_token')),
            403,
        );

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ]);

        DB::transaction(function () use ($validated): void {
            $role = Role::firstOrCreate(['role_name' => 'admin']);

            $user = User::create([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'email' => $validated['email'],
                'username' => $validated['username'],
                'password' => $validated['password'],
                'status' => 'active',
            ]);

            $user->roles()->attach($role->getKey());
        });

        return redirect()
            ->route('login')
            ->with('status', 'Admin account created. You can now sign in.');
    }

    private function setupIsAvailable(): bool
    {
        $setupToken = config('services.initial_admin_setup_token');

        return is_string($setupToken)
            && $setupToken !== '';
    }
}
