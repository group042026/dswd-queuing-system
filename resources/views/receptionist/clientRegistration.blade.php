<x-receptionist-layout>
    <style>
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
            --dswd-yellow-hover: #e0b800;
            --dswd-yellow-light: rgba(252, 209, 22, 0.12);

            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #1e293b;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .registration-container {
            padding: 12px 0;
            color: var(--text-primary);
            
        }

        /* Banner */
        .reg-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .reg-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .reg-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .reg-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .reg-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .reg-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .reg-banner__stripe {
            height: 100%;
            width: 33.333%;
        }
        .reg-banner__stripe--blue { background-color: var(--dswd-blue); }
        .reg-banner__stripe--yellow { background-color: var(--dswd-yellow); }
        .reg-banner__stripe--red { background-color: var(--dswd-red); }

        /* Form Card */
        .reg-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
            transition: var(--transition-smooth);
        }

        .reg-card:hover {
            border-color: rgba(0, 56, 168, 0.2);
            box-shadow: 0 10px 15px -3px rgba(0, 56, 168, 0.05);
        }

        .reg-card__title {
            font-size: 15px;
            font-weight: 800;
            color: var(--dswd-blue);
            margin: 0 0 20px 0;
            padding-bottom: 12px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .reg-card__title-number {
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
            width: 24px;
            height: 24px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 800;
            border: 1px solid var(--dswd-blue-border);
        }

        /* Target all input fields inside our container to override default styles elegantly */
        .max-w-5xl input[type="text"],
        .max-w-5xl input[type="email"],
        .max-w-5xl input[type="number"],
        .max-w-5xl input[type="date"],
        .max-w-5xl select,
        .max-w-5xl textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            color: var(--text-primary);
        }

        .max-w-5xl input:focus,
        .max-w-5xl select:focus,
        .max-w-5xl textarea:focus {
            outline: none !important;
            border-color: var(--dswd-blue) !important;
            box-shadow: 0 0 0 3px var(--dswd-blue-light) !important;
        }

        .max-w-5xl input[readonly] {
            background-color: #f1f5f9;
            color: var(--text-muted);
            cursor: not-allowed;
            border-color: #e2e8f0;
        }

        .action-button-group {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 40px;
        }

        .btn-submit {
            background-color: var(--dswd-blue) !important;
            color: var(--text-white) !important;
            font-weight: 800 !important;
            padding: 12px 24px !important;
            border-radius: 10px !important;
            transition: var(--transition-smooth) !important;
            border: none !important;
            cursor: pointer;
        }

        .btn-submit:hover {
            background-color: var(--dswd-blue-hover) !important;
        }

        .btn-cancel {
            background-color: #f1f5f9 !important;
            color: #475569 !important;
            font-weight: 800 !important;
            padding: 12px 24px !important;
            border-radius: 10px !important;
            border: 1px solid #cbd5e1 !important;
            transition: var(--transition-smooth) !important;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .btn-cancel:hover {
            background-color: #e2e8f0 !important;
            color: #1e293b !important;
        }
    </style>

    <div class="registration-container" x-data="{
        birthdate: '',
        age: '',
        computeAge() {
            if (!this.birthdate) { this.age = ''; return; }
            const today = new Date();
            const bd = new Date(this.birthdate);
            let years = today.getFullYear() - bd.getFullYear();
            const m = today.getMonth() - bd.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) years--;
            this.age = years >= 0 ? years : '';
        }
    }">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <!-- Registration Header Banner -->
            <div class="reg-banner">
                <div class="reg-banner__content">
                    <div class="reg-banner__badge">DSWD Receptionist Portal</div>
                    <h1 class="reg-banner__title">Client Registration</h1>
                    <p class="reg-banner__description">
                        Create client records, auto-compute demographics, specify program details, and automatically route the client to the Validation queue.
                    </p>
                </div>
                <div class="reg-banner__ribbon">
                    <div class="reg-banner__stripe reg-banner__stripe--blue"></div>
                    <div class="reg-banner__stripe reg-banner__stripe--yellow"></div>
                    <div class="reg-banner__stripe reg-banner__stripe--red"></div>
                </div>
            </div>

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form method="POST" action="{{ route('receptionist.clients.store') }}">
                @csrf

                {{-- SECTION 1: Personal Information --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">1</span>
                        {{ __('Personal Information') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1.5 block w-full" :value="old('first_name')" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="middle_name" :value="__('Middle Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1.5 block w-full" :value="old('middle_name')" />
                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1.5 block w-full" :value="old('last_name')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <div>
                            <x-input-label for="suffix" :value="__('Suffix')" class="font-semibold text-gray-700" />
                            <select id="suffix" name="suffix" class="mt-1.5 block w-full">
                                <option value="">-- {{ __('None') }} --</option>
                                <option value="Jr." {{ old('suffix') == 'Jr.' ? 'selected' : '' }}>Jr.</option>
                                <option value="Sr." {{ old('suffix') == 'Sr.' ? 'selected' : '' }}>Sr.</option>
                                <option value="II" {{ old('suffix') == 'II' ? 'selected' : '' }}>II</option>
                                <option value="III" {{ old('suffix') == 'III' ? 'selected' : '' }}>III</option>
                                <option value="IV" {{ old('suffix') == 'IV' ? 'selected' : '' }}>IV</option>
                            </select>
                            <x-input-error :messages="$errors->get('suffix')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="sex" :value="__('Sex')" class="font-semibold text-gray-700" />
                            <select id="sex" name="sex" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="birthdate" :value="__('Birthdate')" class="font-semibold text-gray-700" />
                            <x-text-input
                                id="birthdate"
                                name="birthdate"
                                type="date"
                                class="mt-1.5 block w-full"
                                x-model="birthdate"
                                x-on:change="computeAge()"
                                :value="old('birthdate')"
                                required
                            />
                            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="age" :value="__('Age')" class="font-semibold text-gray-700" />
                            <x-text-input
                                id="age"
                                name="age"
                                type="number"
                                class="mt-1.5 block w-full"
                                x-model="age"
                                readonly
                            />
                            <p class="text-xs text-gray-400 mt-1">{{ __('Auto-computed from birthdate') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mt-6">
                        <div>
                            <x-input-label for="civil_status" :value="__('Civil Status')" class="font-semibold text-gray-700" />
                            <select id="civil_status" name="civil_status" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Single" {{ old('civil_status') == 'Single' ? 'selected' : '' }}>Single</option>
                                <option value="Married" {{ old('civil_status') == 'Married' ? 'selected' : '' }}>Married</option>
                                <option value="Widowed" {{ old('civil_status') == 'Widowed' ? 'selected' : '' }}>Widowed</option>
                                <option value="Separated" {{ old('civil_status') == 'Separated' ? 'selected' : '' }}>Separated</option>
                                <option value="Divorced" {{ old('civil_status') == 'Divorced' ? 'selected' : '' }}>Divorced</option>
                            </select>
                            <x-input-error :messages="$errors->get('civil_status')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="email" :value="__('Email (Optional)')" class="font-semibold text-gray-700" />
                            <x-text-input id="email" name="email" type="email" class="mt-1.5 block w-full" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="occupation" :value="__('Occupation')" class="font-semibold text-gray-700" />
                            <x-text-input id="occupation" name="occupation" type="text" class="mt-1.5 block w-full" :value="old('occupation')" />
                            <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="contact_number" :value="__('Contact Number')" class="font-semibold text-gray-700" />
                            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1.5 block w-full" :value="old('contact_number')" />
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Address --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">2</span>
                        {{ __('Address Details') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="barangay" :value="__('Barangay')" class="font-semibold text-gray-700" />
                            <x-text-input id="barangay" name="barangay" type="text" class="mt-1.5 block w-full" :value="old('barangay')" required />
                            <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="municipality" :value="__('Municipality')" class="font-semibold text-gray-700" />
                            <x-text-input id="municipality" name="municipality" type="text" class="mt-1.5 block w-full" :value="old('municipality')" required />
                            <x-input-error :messages="$errors->get('municipality')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="province" :value="__('Province')" class="font-semibold text-gray-700" />
                            <x-text-input id="province" name="province" type="text" class="mt-1.5 block w-full" :value="old('province')" required />
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Household & Financial Background --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">3</span>
                        {{ __('Household & Financial Background') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="monthly_income" :value="__('Monthly Income')" class="font-semibold text-gray-700" />
                            <x-text-input id="monthly_income" name="monthly_income" type="number" step="0.01" class="mt-1.5 block w-full" :value="old('monthly_income')" required />
                            <x-input-error :messages="$errors->get('monthly_income')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="household_size" :value="__('Household Size')" class="font-semibold text-gray-700" />
                            <x-text-input id="household_size" name="household_size" type="number" min="1" class="mt-1.5 block w-full" :value="old('household_size')" required />
                            <x-input-error :messages="$errors->get('household_size')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: Valid ID --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">4</span>
                        {{ __('Valid Identification') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="valid_id_type" :value="__('Valid ID Type')" class="font-semibold text-gray-700" />
                            <select id="valid_id_type" name="valid_id_type" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Philippine National ID" {{ old('valid_id_type') == 'Philippine National ID' ? 'selected' : '' }}>Philippine National ID</option>
                                <option value="Passport" {{ old('valid_id_type') == 'Passport' ? 'selected' : '' }}>Passport</option>
                                <option value="Driver's License" {{ old('valid_id_type') == "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                                <option value="Voter's ID" {{ old('valid_id_type') == "Voter's ID" ? 'selected' : '' }}>Voter's ID</option>
                                <option value="SSS ID" {{ old('valid_id_type') == 'SSS ID' ? 'selected' : '' }}>SSS ID</option>
                                <option value="PhilHealth ID" {{ old('valid_id_type') == 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
                                <option value="Barangay ID" {{ old('valid_id_type') == 'Barangay ID' ? 'selected' : '' }}>Barangay ID</option>
                                <option value="Other" {{ old('valid_id_type') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('valid_id_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="valid_id_number" :value="__('Valid ID Number')" class="font-semibold text-gray-700" />
                            <x-text-input id="valid_id_number" name="valid_id_number" type="text" class="mt-1.5 block w-full" :value="old('valid_id_number')" required />
                            <x-input-error :messages="$errors->get('valid_id_number')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 5: Assistance Details --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">5</span>
                        {{ __('Assistance Details') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="client_category" :value="__('Client Category')" class="font-semibold text-gray-700" />
                            <select id="client_category" name="client_category" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Senior" {{ old('client_category') == 'Senior' ? 'selected' : '' }}>Senior Citizen</option>
                                <option value="PWD" {{ old('client_category') == 'PWD' ? 'selected' : '' }}>PWD</option>
                                <option value="Pregnant Woman" {{ old('client_category') == 'Pregnant Woman' ? 'selected' : '' }}>Pregnant Woman</option>
                                <option value="Regular" {{ old('client_category') == 'Regular' ? 'selected' : '' }}>Regular</option>
                            </select>
                            <x-input-error :messages="$errors->get('client_category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="program_requested" :value="__('Program Requested')" class="font-semibold text-gray-700" />
                            <select id="program_requested" name="program_requested" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="AICS" {{ old('program_requested') == 'AICS' ? 'selected' : '' }}>AICS (Assistance to Individuals in Crisis Situation)</option>
                                <option value="Other" {{ old('program_requested') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('program_requested')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-6">
                        <x-input-label for="reason_for_assistance" :value="__('Reason for Assistance')" class="font-semibold text-gray-700" />
                        <textarea id="reason_for_assistance" name="reason_for_assistance" rows="4" class="mt-1.5 block w-full" required>{{ old('reason_for_assistance') }}</textarea>
                        <x-input-error :messages="$errors->get('reason_for_assistance')" class="mt-2" />
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="action-button-group">
                    <a href="{{ route('receptionist.dashboard') }}" class="btn-cancel">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit" class="btn-submit">
                        {{ __('Register Client') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-receptionist-layout>