<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User List') }}
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
                                <td class="p-3">
                                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ ucfirst($user->status ?? 'active') }}
                                    </span>
                                </td>                           {{-- // User → Roles: belongsToMany (Many-to-Many, dahil may pivot table) --}}
                                                                {{-- kaya need gumamit ng first() para maaccess yung name dahil collection sya and marami kase belongstomany --}}
                                <td class="p-3">{{ $user->roles->first()->role_name }}</td> 
                                <td class="p-3">
                                    <div class="flex items-center gap-2">
                                        {{-- VIEW --}}
                                        <x-icon-button color="blue" x-data="" x-on:click="$dispatch('open-modal', 'view-user-modal-{{ $user->id }}')" title="View">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </x-icon-button>

                                        {{-- EDIT --}}
                                        <x-icon-button color="blue" x-data="" x-on:click="$dispatch('open-modal', 'edit-user-modal-{{ $user->id }}')" title="Edit">
                                        
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </x-icon-button>

                                        {{-- DELETE --}}
                                        <x-icon-button color="red" x-data="" x-on:click="$dispatch('open-modal', 'delete-user-modal-{{ $user->id }}')" title="Delete">
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
    <x-modal name="add-user-modal" focusable :show="$errors->any() && !old('editing_user_id')">
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
                <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number')" required />
                <x-input-error :messages="$errors->get('license_number')" class="mt-2" />

            </div>

            <div class="mb-4">
                <x-input-label for="contact_number" :value="__('Contact Number')" />
                <x-text-input id="contact_number" name="contact_number" type="number" class="mt-1 block w-full" :value="old('contact_number')" required />
                <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />

            </div>

            <div class="mb-4">
                <x-input-label for="role" :value="__('Role')" />
                <select id="role" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    <option value="">-- Select Role --</option>
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ old('role') == $role->id ? 'selected' : '' }}>
                            {{ $role->role_name }}
                        </option>
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
                    <img src="{{ asset('storage/profile-images/defaultImage.png') }}"
                            class="h-24 w-24 rounded-full object-cover border">
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

    @foreach($users as $user)
        {{-- Modal — form para mag-edit ng user --}}
        <x-modal name="edit-user-modal-{{ $user->id }}" focusable :show="$errors->any() && old('editing_user_id') == $user->id">            
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                            <input type="hidden" name="editing_user_id" value="{{ $user->id }}">

                <h2 class="text-lg font-medium text-gray-900 mb-4">
                    {{ __('Edit User') }}
                </h2>

                    <div class="mb-4">
                        <x-input-label for="edit_first_name_{{ $user->id }}" :value="__('First Name')" />
                        <x-text-input id="edit_first_name_{{ $user->id }}" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required autofocus />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                <div class="mb-4">
                    <x-input-label for="edit_middle_name_{{ $user->id }}" :value="__('Middle Name')" />
                    <x-text-input id="edit_middle_name_{{ $user->id }}" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" required autofocus />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="_edit_last_name_{{ $user->id }}" :value="__('Last Name')" />
                    <x-text-input id="edit_last_name_{{ $user->id }}" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_email_{{ $user->id }}" :value="__('Email')" />
                    <x-text-input id="edit_email_{{ $user->id }}" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_username_{{ $user->id }}" :value="__('Username')" />
                    <x-text-input id="edit_username_{{ $user->id }}" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>
                    <p class="text-xs italic text-red-500 mb-2">
                        Leave blank if you don't want to change the password.
                    </p>

                <div class="mb-4">
                    <x-input-label for="edit_password_{{ $user->id }}" :value="__('Password')" />
                    <x-text-input id="edit_password_{{ $user->id }}" name="password" type="password" class="mt-1 block w-full"/>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_password_confirmation_{{ $user->id }}" :value="__('Confirm Password')" />
                    <x-text-input id="edit_password_confirmation_{{ $user->id }}" name="password_confirmation" type="password" class="mt-1 block w-full"/>
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_license_number_{{ $user->id }}" :value="__('License Number')" />
                    <x-text-input id="edit_license_number_{{ $user->id }}" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number', $user->license_number)" required />
                    <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_contact_number_{{ $user->id }}" :value="__('Contact Number')" />
                    <x-text-input id="edit_contact_number_{{ $user->id }}" name="contact_number" type="text" inputmode="numeric" class="mt-1 block w-full" :value="old('contact_number', $user->contact_number)" required />
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_role_{{ $user->id }}" :value="__('Role')" />
                    <select id="edit_role_{{ $user->id }}" name="role" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="">-- Select Role --</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" 
                                {{ old('role', $user->roles->first()->id ?? '') == $role->id ? 'selected' : '' }}>
                                {{ $role->role_name }}
                            </option>                    
                        @endforeach
                        
                    </select>
                    <x-input-error :messages="$errors->get('role')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_status_{{ $user->id }}" :value="__('Status')" />
                    <select id="edit_status_{{ $user->id }}" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="edit_profile_image_{{ $user->id }}" :value="__('Profile Image')" />

                    <div class="mb-2">
                        <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('storage/profile-images/defaultImage.png') }}"
                            class="h-24 w-24 rounded-full object-cover border">
                    </div>
                    <input
                        id="edit_profile_image_{{ $user->id }}"
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
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-user-modal-{{ $user->id }}')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button type="submit">
                        {{ __('Update User') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

    {{-- Modal — view --}}
    <x-modal name="view-user-modal-{{ $user->id }}" focusable>
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 mb-4">
                {{ __('User Details') }}
            </h2>

            {{-- Profile Image --}}
            <div class="flex justify-center mb-6">
                <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('storage/profile-images/defaultImage.png') }}"
                    class="h-24 w-24 rounded-full object-cover border">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('First Name') }}</p>
                    <p class="text-gray-900">{{ $user->first_name }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Middle Name') }}</p>
                    <p class="text-gray-900">{{ $user->middle_name ?? '—' }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Last Name') }}</p>
                    <p class="text-gray-900">{{ $user->last_name }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Email') }}</p>
                    <p class="text-gray-900">{{ $user->email }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Username') }}</p>
                    <p class="text-gray-900">{{ $user->username }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('License Number') }}</p>
                    <p class="text-gray-900">{{ $user->license_number }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Contact Number') }}</p>
                    <p class="text-gray-900">{{ $user->contact_number }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Role') }}</p>
                    <p class="text-gray-900">{{ $user->roles->first()->role_name ?? '—' }}</p>
                </div>

                <div class="mb-2">
                    <p class="text-sm font-medium text-gray-500">{{ __('Status') }}</p>
                    <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full
                        {{ $user->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">

                        {{ ucfirst($user->status ?? 'active') }}
                    </span>
                </div>
            </div>

            <div class="flex justify-end mt-6">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'view-user-modal-{{ $user->id }}')">
                    {{ __('Close') }}
                </x-secondary-button>
            </div>
        </div>
    </x-modal>

    {{-- Modal — delete --}}
    <x-modal name="delete-user-modal-{{ $user->id }}" focusable>
        <div class="p-6">
            <div class="flex items-center gap-3 mb-4">
                <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                    <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h2 class="text-lg font-medium text-gray-900">
                    {{ __('Delete User') }}
                </h2>
            </div>

            <p class="text-sm text-gray-600 mb-6">
                {{ __('Are you sure you want to delete') }}
                <span class="font-semibold">{{ $user->first_name }} {{ $user->last_name }}</span>?
                {{ __('This action cannot be undone.') }}
            </p>

            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3">
                    <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'delete-user-modal-{{ $user->id }}')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:ring-red-500">
                        {{ __('Delete') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </x-modal>
    @endforeach

</x-admin-layout>