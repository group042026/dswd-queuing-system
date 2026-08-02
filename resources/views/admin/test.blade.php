<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">{{ __('Users') }}</h3>
                    {{-- <div class="py-6" x-data="">  --}} <!-- GAMITIN ITO KAPAG MARAMING MODAL PARA HINDI PAULIT ULIT SA PRIMARYBUTTON YUNG X-DATA="" -->

                    {{-- Button na nag-trigger ng modal --}}
                    <x-primary-button x-data="" x-on:click="$dispatch('open-modal', 'add-user-modal')">
                        {{ __('Add User') }}
                    </x-primary-button>
                </div>

                {{-- Simpleng table --}}
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Name</th>
                            <th class="p-3">Email</th>
                            <th class="p-3">Username</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Role</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr class="border-b">
                                <td class="p-3">{{ $user->first_name }} {{ $user->last_name }}</td>
                                <td class="p-3">{{ $user->email }}</td>
                                <td class="p-3">{{ $user->username }}</td>
                                <td class="p-3">{{ $user->status ?? 'Active' }}</td>
                                                                {{-- // User → Roles: belongsToMany (Many-to-Many, dahil may pivot table) --}}
                                                                {{-- kaya need gumamit ng first() para maaccess yung name dahil collection sya and marami kase belongstomany --}}
                                <td class="p-3">{{ $user->roles->first()->role_name }}</td> 
                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        {{-- VIEW --}}
                                        <x-icon-button color="blue" x-on:click="$dispatch('open-modal', 'view-user-modal-{{ $user->id }}')" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </x-icon-button>

                                        {{-- EDIT --}}
                                        <x-icon-button
                                            color="indigo"
                                            x-on:click="
                                                $dispatch('open-modal', 'edit-user-modal');
                                            "
                                            title="Edit"
                                        >                                            
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </x-icon-button>

                                        {{-- DELETE --}}
                                        <x-icon-button color="red" x-on:click="$dispatch('open-modal', 'delete-user-modal-{{ $user->id }}')" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </x-icon-button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">No users yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{$users->links()}}
            </div>
        </div>
    </div>

    {{-- Modal — form para mag-add ng user --}}
    <x-modal name="add-user-modal" focusable :show="$errors->any()" >
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('Add New User') }}
            </h2>

            <div class="mb-4">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name')" required autofocus />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>

            
            
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" name="password" type="password" class="mt-1 block w-full"/>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full"/>
            </div>

            <div class="mb-4">
                <x-input-label for="license_number" :value="__('License Number')" />
                <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" required />
            </div>

            <div class="mb-4">
                <x-input-label for="contact_number" :value="__('Contact Number')" />
                <x-text-input id="contact_number" name="contact_number" type="number" class="mt-1 block w-full" required />
            </div>

            <div class="mb-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{$role->role_name}}</option>

                       
                    @endforeach
                    
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="profile_image" :value="__('Profile Image')" />
                <div class="mb-4">
                    <img
                        id="editProfilePreview"
                        src=""
                        class="h-24 w-24 rounded-full object-cover border"
                    >
                </div>
                <input
                    id="profile_image"
                    name="profile_image"
                    type="file"
                    accept="image/*"
                    class="block w-full mt-1 text-sm text-gray-700
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-medium
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100"
                >

                <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'add-user-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Update User') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>


    {{-- Modal — form para mag-edit ng user --}}
    <x-modal name="edit-user-modal" focusable :show="$errors->any()" >
        <form method="POST" class="p-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('Edit User') }}
            </h2>

            <div class="mb-4">
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="edit_first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="middle_name" :value="__('Middle Name')" />
                <x-text-input id="edit_middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name')" required autofocus />
                <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="edit_last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="edit_email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="username" :value="__('Username')" />
                <x-text-input id="edit_username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required />
                <x-input-error :messages="$errors->get('username')" class="mt-2" />
            </div>
                <p class="text-xs text-gray-500 mb-2">
                    Leave blank if you don't want to change the password.
                </p>
            <div class="mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="edit_password" name="password" type="password" class="mt-1 block w-full" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="edit_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
            </div>

            <div class="mb-4">
                <x-input-label for="license_number" :value="__('License Number')" />
                <x-text-input id="edit_license_number" name="license_number" type="text" class="mt-1 block w-full" required />
            </div>

            <div class="mb-4">
                <x-input-label for="contact_number" :value="__('Contact Number')" />
                <x-text-input id="edit_contact_number" name="contact_number" type="number" class="mt-1 block w-full" required />
            </div>

            <div class="mb-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="edit_role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}">{{$role->role_name}}</option>

                       
                    @endforeach
                    
                </select>
                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="status" :value="__('Status')" />
                <select id="edit_status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                </select>
                <x-input-error :messages="$errors->get('status')" class="mt-2" />
            </div>

            <div class="mb-4">
                <x-input-label for="profile_image" :value="__('Profile Image')" />

                <input
                    id="edit_profile_image"
                    name="profile_image"
                    type="file"
                    accept="image/*"
                    class="block w-full mt-1 text-sm text-gray-700
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-md file:border-0
                        file:text-sm file:font-medium
                        file:bg-indigo-50 file:text-indigo-700
                        hover:file:bg-indigo-100"
                >

                <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
            </div>

            <div class="flex justify-end gap-3 mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'add-user-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit">
                    {{ __('Save User') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

</x-admin-layout>