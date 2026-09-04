<x-admin-layout>
    <style>
        /* ==========================================================================
           1. Core Variables & Theme Styles
           ========================================================================== */
        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;
            --dswd-blue-light: rgba(0, 56, 168, 0.06);
            --dswd-blue-border: rgba(0, 56, 168, 0.12);

            --dswd-red: #ce1126;
            --dswd-red-hover: #b00e1f;
            --dswd-red-light: rgba(206, 17, 38, 0.06);
            --dswd-red-border: rgba(206, 17, 38, 0.12);

            --dswd-yellow: #fcd116;
            --dswd-yellow-light: rgba(252, 209, 22, 0.12);

            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark {
            --bg-gray: #0f172a;
            --card-bg: #1e293b;
            --border-color: #334155;
            --text-primary: #f8fafc;
            --text-muted: #94a3b8;

            --dswd-blue-light: rgba(30, 64, 175, 0.2);
            --dswd-blue-border: rgba(30, 64, 175, 0.35);

            --dswd-red-light: rgba(220, 38, 38, 0.2);
            --dswd-red-border: rgba(220, 38, 38, 0.35);

            --dswd-yellow-light: rgba(252, 209, 22, 0.15);
        }

        .dark .user-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .dark .user-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .user-table tr:hover td {
            background-color: rgba(30, 64, 175, 0.05);
        }

        .dark .user-identity__name {
            color: #f8fafc;
        }

        .dark .user-card {
            border-color: #334155;
        }

        .dark .user-card__header {
            border-bottom-color: #334155;
        }

        .dark .user-card__title {
            color: #f8fafc;
        }

        .dark .user-pagination {
            border-top-color: #334155;
        }

        /* Modal Forms & Details Layout in Dark Mode */
        .dark input[type="text"],
        .dark input[type="email"],
        .dark input[type="number"],
        .dark input[type="password"],
        .dark label {
            background-color: #1e293b !important;
            border-color: #475569 !important;
            color: #f1f5f9 !important;
        }
        .dark select {
            background-color: #1e293b !important;
            border-color: #475569 !important;
            color: #f1f5f9 !important;
        }

        .dark .text-gray-900 {
            color: #f8fafc !important;
        }

        .dark .text-gray-600 {
            color: #cbd5e1 !important;
        }

        .dark .bg-red-100 {
            background-color: rgba(220, 38, 38, 0.2) !important;
        }

        .dark .user-detail-row {
            border-bottom-color: #334155 !important;
        }

        .dark .user-detail-value {
            color: #cbd5e1;
        }

        .dark .user-detail-avatar {
            border-color: #475569;
        }

        .user-panel {
            padding: 24px 0;
            /* background-color: var(--bg-gray); */
            min-height: 100vh;
        }

        .user-panel__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* ==========================================================================
           4. Header
           ========================================================================== */

        .activity-header {
            background: linear-gradient(
                135deg,
                var(--dswd-blue) 0%,
                #1e40af 50%,
                var(--dswd-red) 100%
            );

            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

            color: var(--text-white);
            padding: 24px;
            position: relative;
        }

        .activity-header__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .activity-header__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .activity-header__title {
            font-size: 26px;
            font-weight: 850;
            margin: 0 0 6px 0;
        }

        .activity-header__subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            margin: 0;
        }


        /* Success Alert Banner */
        .user-panel__alert {
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
            padding: 16px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Master Panel Card */
        .user-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: 4px solid var(--dswd-blue);
            overflow: hidden;
        }

        .user-card__header {
            padding: 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
        }

        .user-card__title-group {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .user-card__title {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .user-card__subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin: 0;
        }

        /* Add User Trigger Button */
        .btn-add-user {
            background-color: var(--dswd-blue);
            color: var(--text-white);
            border-radius: 10px;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border: none;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 4px 12px rgba(0, 56, 168, 0.15);
        }

        .btn-add-user:hover {
            background-color: var(--dswd-blue-hover);
            transform: translateY(-1px);
            box-shadow: 0 6px 16px rgba(0, 56, 168, 0.25);
        }

        /* User Table Component */
        .user-table-wrapper {
            overflow-x: auto;
        }

        .user-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .user-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .user-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }

        .user-table tr:hover td {
            background-color: rgba(0, 56, 168, 0.015);
        }

        /* User Identity Block */
        .user-identity {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-identity__avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 1.5px solid #e2e8f0;
            background-color: #f1f5f9;
        }

        .user-identity__info {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .user-identity__name {
            font-weight: 800;
            color: #1e293b;
            font-size: 14px;
        }

        .user-identity__email {
            font-size: 12px;
            color: var(--text-muted);
            font-weight: 500;
        }

        .user-identity__username {
            font-size: 11px;
            color: var(--text-muted);
            font-family: monospace;
            font-weight: 500;
        }

        /* Badges */
        .user-role-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
            border: 1px solid var(--dswd-blue-border);
        }

        .user-status-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            border: 1px solid;
        }

        .user-status-badge--active {
            background-color: #ecfdf5;
            color: #047857;
            border-color: #a7f3d0;
        }

        .user-status-badge--inactive {
            background-color: var(--dswd-red-light);
            color: var(--dswd-red);
            border-color: var(--dswd-red-border);
        }

        /* Action Buttons */
        .user-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Pagination Component */
        .user-pagination {
            padding: 20px 24px;
            border-top: 1px solid #f1f5f9;
        }

        /* Modal Forms & Details Layout */
        .modal-form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .modal-form-grid__span-2 {
            grid-column: span 2;
        }

        .user-detail-row {
            padding: 8px 0;
            border-bottom: 1px solid #f8fafc;
        }

        .user-detail-label {
            font-size: 12px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 2px;
        }

        .user-detail-value {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
        }

        .user-detail-avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 24px;
        }

        .user-detail-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #cbd5e1;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .image-preview-group {
            display: flex;
            align-items: center;
            gap: 16px;
            margin-top: 8px;
        }

        .image-preview-img {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #cbd5e1;
        }

        /* Custom Form Input Fields Focus Styling */
        input[type="text"], input[type="email"], input[type="number"], input[type="password"], select {
            border-radius: 8px !important;
            border: 1.5px solid #cbd5e1 !important;
            transition: var(--transition-smooth);
        }

        input[type="text"]:focus, input[type="email"]:focus, input[type="number"]:focus, input[type="password"]:focus, select:focus {
            border-color: var(--dswd-blue) !important;
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.12) !important;
        }

        @media (max-width: 640px) {

            .user-panel__container {
                padding: 0 16px;
            }

            .activity-header {
                padding: 20px;
            }

            .activity-header__title {
                font-size: 22px;
            }
        }
    </style>

    <div class="user-panel">
        <div class="user-panel__container">

            <div class="activity-header">

                {{-- Background Icon --}}
                <div class="activity-header__bg-icon">

                    <svg
                        width="240"
                        height="240"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
                            10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92
                            C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1
                            1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41
                            0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76
                            2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"
                        />
                    </svg>

                </div>


                <div>

                    <p class="activity-header__badge">
                        DSWD Operations Control Hub
                    </p>

                    <h1 class="activity-header__title">
                        User List
                    </h1>

                    <p class="activity-header__subtitle">
                        Review and monitor user actions and system activities across all program desks
                        
                    </p>

                </div>

            </div>

            {{-- Success Notification Banner --}}
            @if (session('success'))
                <div class="user-panel__alert">
                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="user-card">
                <div class="user-card__header">
                    <div class="user-card__title-group">
                        <h3 class="user-card__title">Registered System Operators</h3>
                        <p class="user-card__subtitle">Manage credentials, permissions, and status of department staff members</p>
                    </div>

                    {{-- Add User Button --}}
                    <button type="button" class="btn-add-user" x-data="" x-on:click="$dispatch('open-modal', 'add-user-modal')">
                        {{ __('Add Operator') }}
                    </button>
                </div>

                {{-- User list table --}}
                <div class="user-table-wrapper">
                    <table class="user-table">
                        <thead>
                            <tr>
                                <th>Operator Info</th>
                                <th>Username</th>
                                <th>Role</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>
                                        <div class="user-identity">
                                            <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('storage/profile-images/defaultImage.png') }}"
                                                 class="user-identity__avatar" alt="Avatar">
                                            <div class="user-identity__info">
                                                <span class="user-identity__name">{{ $user->first_name }} {{ $user->last_name }}</span>
                                                <span class="user-identity__email">{{ $user->email }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="user-identity__username">{{ $user->username }}</span>
                                    </td>
                                    <td>
                                        <span class="user-role-badge">
                                            {{ $user->roles->first()->role_name ?? 'Operator' }}
                                        </span>
                                    </td>
                                    <td>
                                        @php $isActive = $user->status === 'active'; @endphp
                                        <span class="user-status-badge {{ $isActive ? 'user-status-badge--active' : 'user-status-badge--inactive' }}">
                                            {{ ucfirst($user->status ?? 'active') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="user-actions">
                                            {{-- VIEW USER --}}
                                            <x-icon-button color="blue" x-data="" x-on:click="$dispatch('open-modal', 'view-user-modal-{{ $user->id }}')" title="View">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </x-icon-button>

                                            {{-- EDIT USER --}}
                                            <x-icon-button color="blue" x-data="" x-on:click="$dispatch('open-modal', 'edit-user-modal-{{ $user->id }}')" title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </x-icon-button>

                                            {{-- DELETE USER --}}
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
                                    <td colspan="5" class="p-8 text-center text-gray-400 font-semibold">
                                        No registered operators found in the system.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination Links container --}}
                <div class="user-pagination">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>

    {{-- Modal — Add operator --}}
    <x-modal name="add-user-modal" focusable :show="$errors->any() && !old('editing_user_id')">
        <form method="POST" action="{{ route('admin.users.store') }}" class="p-6" enctype="multipart/form-data">
            @csrf

            <h2 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                {{ __('Add New Operator') }}
            </h2>

            <div class="modal-form-grid">
                <div>
                    <x-input-label for="first_name" :value="__('First Name')" />
                    <x-text-input id="first_name" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name')" required autofocus />
                    <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="middle_name" :value="__('Middle Name')" />
                    <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name')" />
                    <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                </div>

                <div class="modal-form-grid__span-2">
                    <x-input-label for="last_name" :value="__('Last Name')" />
                    <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                    <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                </div>

                <div class="modal-form-grid__span-2">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" required />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="modal-form-grid__span-2">
                    <x-input-label for="username" :value="__('Username')" />
                    <x-text-input id="username" name="username" type="text" class="mt-1 block w-full" :value="old('username')" required />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" class="mt-1 block w-full" required />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full" required />
                </div>

                <div>
                    <x-input-label for="license_number" :value="__('License Number')" />
                    <x-text-input id="license_number" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number')" required />
                    <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                </div>

                <div>
                    <x-input-label for="contact_number" :value="__('Contact Number')" />
                    <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number')" required />
                    <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                </div>

                <div>
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

                <div>
                    <x-input-label for="status" :value="__('Status')" />
                    <select id="status" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                    <x-input-error :messages="$errors->get('status')" class="mt-2" />
                </div>

                <div class="modal-form-grid__span-2">
                    <x-input-label for="profile_image" :value="__('Profile Image')" />
                    <div class="image-preview-group">
                        <img src="{{ asset('storage/profile-images/defaultImage.png') }}" class="image-preview-img" alt="Default Preview">
                        <input id="profile_image" name="profile_image" type="file" accept="image/*" class="block w-full mt-1 text-sm text-gray-700">
                    </div>
                    <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                </div>
            </div>

            <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                <x-secondary-button x-on:click="$dispatch('close-modal', 'add-user-modal')">
                    {{ __('Cancel') }}
                </x-secondary-button>
                <x-primary-button type="submit" style="background-color: var(--dswd-blue);">
                    {{ __('Save Operator') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>

    @foreach($users as $user)
        {{-- Modal — Edit operator --}}
        <x-modal name="edit-user-modal-{{ $user->id }}" focusable :show="$errors->any() && old('editing_user_id') == $user->id">
            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" class="p-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="editing_user_id" value="{{ $user->id }}">

                <h2 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                    {{ __('Edit Operator Details') }}
                </h2>

                <div class="modal-form-grid">
                    <div>
                        <x-input-label for="edit_first_name_{{ $user->id }}" :value="__('First Name')" />
                        <x-text-input id="edit_first_name_{{ $user->id }}" name="first_name" type="text" class="mt-1 block w-full" :value="old('first_name', $user->first_name)" required />
                        <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_middle_name_{{ $user->id }}" :value="__('Middle Name')" />
                        <x-text-input id="edit_middle_name_{{ $user->id }}" name="middle_name" type="text" class="mt-1 block w-full" :value="old('middle_name', $user->middle_name)" required />
                        <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                    </div>

                    <div class="modal-form-grid__span-2">
                        <x-input-label for="edit_last_name_{{ $user->id }}" :value="__('Last Name')" />
                        <x-text-input id="edit_last_name_{{ $user->id }}" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name', $user->last_name)" required />
                        <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                    </div>

                    <div class="modal-form-grid__span-2">
                        <x-input-label for="edit_email_{{ $user->id }}" :value="__('Email')" />
                        <x-text-input id="edit_email_{{ $user->id }}" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="modal-form-grid__span-2">
                        <x-input-label for="edit_username_{{ $user->id }}" :value="__('Username')" />
                        <x-text-input id="edit_username_{{ $user->id }}" name="username" type="text" class="mt-1 block w-full" :value="old('username', $user->username)" required />
                        <x-input-error :messages="$errors->get('username')" class="mt-2" />
                    </div>

                    <div class="modal-form-grid__span-2">
                        <span class="text-xs italic text-amber-600 block mt-1">Leave blank if you do not wish to alter the password.</span>
                    </div>

                    <div>
                        <x-input-label for="edit_password_{{ $user->id }}" :value="__('Password')" />
                        <x-text-input id="edit_password_{{ $user->id }}" name="password" type="password" class="mt-1 block w-full" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_password_confirmation_{{ $user->id }}" :value="__('Confirm Password')" />
                        <x-text-input id="edit_password_confirmation_{{ $user->id }}" name="password_confirmation" type="password" class="mt-1 block w-full" />
                    </div>

                    <div>
                        <x-input-label for="edit_license_number_{{ $user->id }}" :value="__('License Number')" />
                        <x-text-input id="edit_license_number_{{ $user->id }}" name="license_number" type="text" class="mt-1 block w-full" :value="old('license_number', $user->license_number)" required />
                        <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="edit_contact_number_{{ $user->id }}" :value="__('Contact Number')" />
                        <x-text-input id="edit_contact_number_{{ $user->id }}" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number', $user->contact_number)" required />
                        <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                    </div>

                    <div>
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

                    <div>
                        <x-input-label for="edit_status_{{ $user->id }}" :value="__('Status')" />
                        <select id="edit_status_{{ $user->id }}" name="status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="active" {{ old('status', $user->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $user->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>

                    <div class="modal-form-grid__span-2">
                        <x-input-label for="edit_profile_image_{{ $user->id }}" :value="__('Profile Image')" />
                        <div class="image-preview-group">
                            <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('storage/profile-images/defaultImage.png') }}" class="image-preview-img" alt="Current Image">
                            <input id="edit_profile_image_{{ $user->id }}" name="profile_image" type="file" accept="image/*" class="block w-full mt-1 text-sm text-gray-700">
                        </div>
                        <x-input-error :messages="$errors->get('profile_image')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-end gap-3 mt-6 pt-4 border-t border-gray-100">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'edit-user-modal-{{ $user->id }}')">
                        {{ __('Cancel') }}
                    </x-secondary-button>
                    <x-primary-button type="submit" style="background-color: var(--dswd-blue);">
                        {{ __('Update Details') }}
                    </x-primary-button>
                </div>
            </form>
        </x-modal>

        {{-- Modal — View Details --}}
        <x-modal name="view-user-modal-{{ $user->id }}" focusable>
            <div class="p-6">
                <h2 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                    {{ __('Operator Profile Details') }}
                </h2>

                <div class="user-detail-avatar-container">
                    <img src="{{ $user->profile_image ? asset('storage/'.$user->profile_image) : asset('storage/profile-images/defaultImage.png') }}"
                         class="user-detail-avatar" alt="Avatar">
                </div>

                <div class="modal-form-grid">
                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('First Name') }}</div>
                        <div class="user-detail-value">{{ $user->first_name }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Middle Name') }}</div>
                        <div class="user-detail-value">{{ $user->middle_name ?? '—' }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Last Name') }}</div>
                        <div class="user-detail-value">{{ $user->last_name }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Email') }}</div>
                        <div class="user-detail-value">{{ $user->email }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Username') }}</div>
                        <div class="user-detail-value font-mono">{{ $user->username }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('License Number') }}</div>
                        <div class="user-detail-value">{{ $user->license_number }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Contact Number') }}</div>
                        <div class="user-detail-value">{{ $user->contact_number }}</div>
                    </div>

                    <div class="user-detail-row">
                        <div class="user-detail-label">{{ __('Role') }}</div>
                        <div class="user-detail-value">{{ $user->roles->first()->role_name ?? '—' }}</div>
                    </div>

                    <div class="user-detail-row modal-form-grid__span-2">
                        <div class="user-detail-label">{{ __('Status') }}</div>
                        <span class="user-status-badge {{ $isActive ? 'user-status-badge--active' : 'user-status-badge--inactive' }} mt-1">
                            {{ ucfirst($user->status ?? 'active') }}
                        </span>
                    </div>
                </div>

                <div class="flex justify-end mt-6 pt-4 border-t border-gray-100">
                    <x-secondary-button x-on:click="$dispatch('close-modal', 'view-user-modal-{{ $user->id }}')">
                        {{ __('Close') }}
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>

        {{-- Modal — Delete --}}
        <x-modal name="delete-user-modal-{{ $user->id }}" focusable>
            <div class="p-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <h2 class="text-lg font-bold text-gray-900">
                        {{ __('Delete Operator Account') }}
                    </h2>
                </div>

                <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                    Are you sure you want to permanently delete the operator account for
                    <span class="font-bold text-gray-900">{{ $user->first_name }} {{ $user->last_name }}</span>?
                    This action cannot be undone and they will lose all dashboard privileges immediately.
                </p>

                <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}">
                    @csrf
                    @method('DELETE')

                    <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                        <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'delete-user-modal-{{ $user->id }}')">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                        <x-primary-button type="submit" class="bg-red-600 hover:bg-red-700 focus:bg-red-700 active:bg-red-800 focus:ring-red-500 text-white">
                            {{ __('Delete Account') }}
                        </x-primary-button>
                    </div>
                </form>
            </div>
        </x-modal>
    @endforeach
</x-admin-layout>
