<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function userList()
    {
        Gate::authorize('access-admin');

        $users = User::with('roles')
                ->where('id', '!=', auth()->id())
                ->orderBy('first_name', 'asc')
                ->paginate(5);
        $roles = Role::all();

        return view('admin.userList', ["users" => $users, "roles" => $roles]);
    }

    


    public function storeUser(Request $request){
        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username'],
            'password' => ['required', 'confirmed', 'min:8'],
            'license_number' => ['required', 'string', 'alpha_num', 'min:5', 'max:20', 'unique:users,license_number'],
            'role' => ['required', 'exists:roles,id'],
            'contact_number' => ['required', 'string', 'min:7', 'max:15', 'regex:/^\+?[0-9\s\-]+$/'],
            'status' => ['required', 'in:active,inactive'],
            'profile_image' => ['nullable', 'image', 'mimes:png,jpg,jpeg,gif', 'max:20480'],

        ]);

        
        if($request->hasFile('profile_image')){
                $validated['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }

        $user = User::create([
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'],
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => bcrypt($validated['password']),
            'license_number' => $validated['license_number'],
            'contact_number' => $validated['contact_number'],
            'status' => $validated['status'],
            'profile_image' => $validated['profile_image'] ?? null,
        ]);


        $user->roles()->attach($validated['role']);

        return redirect()->route('admin.users.list')->with('success', 'User added successfully.');
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'first_name'      => ['required', 'string', 'max:255'],
            'middle_name'     => ['required', 'string', 'max:255'],
            'last_name'       => ['required', 'string', 'max:255'],
            'email'           => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'username'        => ['required', Rule::unique('users')->ignore($user->id)],
            'license_number'  => ['required', Rule::unique('users')->ignore($user->id)],
            'contact_number'  => ['required'],
            'status'          => ['required'],
            'role'            => ['required', 'exists:roles,id'],
            'profile_image'   => ['nullable', 'image'],
            'password'        => ['nullable', 'confirmed', 'min:8'],
        ]);

        if ($request->hasFile('profile_image')) {

            // delete old image dito (optional)

            $validated['profile_image'] =
                $request->file('profile_image')
                        ->store('profile-images', 'public');
        }

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        $user->update($validated);

        $user->roles()->sync([$validated['role']]);

        return redirect()->route('admin.users.list')->with('success', 'User updated successfully.');

    }

    // public function showUser(User $user)
    // {
    //     Gate::authorize('access-admin');
    //     return response()->json($user->load('roles'));
    // }
    public function destroy(User $user)
    {
        Gate::authorize('access-admin');

        // Optional: burahin din yung profile image sa storage kung meron
        if ($user->profile_image) {
            Storage::disk('public')->delete($user->profile_image);
        }

        $user->roles()->detach(); // tanggalin muna sa pivot table bago i-delete yung user
        $user->delete();

        return redirect()->route('admin.dashboard')->with('success', 'User deleted successfully.');
    }
}
