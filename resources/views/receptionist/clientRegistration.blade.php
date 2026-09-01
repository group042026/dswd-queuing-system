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

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div>
                            <x-input-label for="region" :value="__('Region')" class="font-semibold text-gray-700" />
                            <select id="region" name="region" class="mt-1.5 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- {{ __('Select Region') }} --</option>
                            </select>
                            <x-input-error :messages="$errors->get('region')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="province" :value="__('Province')" class="font-semibold text-gray-700" />
                            <select id="province" name="province" class="mt-1.5 block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                                <option value="">-- {{ __('Select Region First') }} --</option>
                            </select>
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="municipality" :value="__('Municipality/City')" class="font-semibold text-gray-700" />
                            <select id="municipality" name="municipality" class="mt-1.5 block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                                <option value="">-- {{ __('Select Province First') }} --</option>
                            </select>
                            <x-input-error :messages="$errors->get('municipality')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="barangay" :value="__('Barangay')" class="font-semibold text-gray-700" />
                            <select id="barangay" name="barangay" class="mt-1.5 block w-full border-gray-300 rounded-md shadow-sm" required disabled>
                                <option value="">-- {{ __('Select Municipality First') }} --</option>
                            </select>
                            <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
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
                            <x-input-label for="salary" :value="__('Salary')" class="font-semibold text-gray-700" />
                            <x-text-input id="salary" name="salary" type="number" step="0.01" class="mt-1.5 block w-full" :value="old('salary')" />
                            <x-input-error :messages="$errors->get('salary')" class="mt-2" />
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
                                <option value="Senior Citizens" {{ old('client_category') == 'Senior Citizens' ? 'selected' : '' }}>Senior Citizen</option>
                                <option value="Family heads and Other Needy Adult" {{ old('client_category') == 'Family heads and Other Needy Adult' ? 'selected' : '' }}>Family heads and Other Needy Adult</option>
                                <option value="Youth in Need and Other Needy Adult" {{ old('client_category') == 'Youth in Need and Other Needy Adult' ? 'selected' : '' }}>Youth in Need and Other Needy Adult</option>
                                <option value="Youth in Need of Special Protection" {{ old('client_category') == 'Youth in Need of Special Protection' ? 'selected' : '' }}>Youth in Need of Special Protection</option>
                                <option value="Men/Women in specially difficult circumstances" {{ old('client_category') == 'Men/Women in specially difficult circumstances' ? 'selected' : '' }}>Men/Women in specially difficult circumstances</option>
                            </select>
                            <x-input-error :messages="$errors->get('client_category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="subcategory" :value="__('Subcategory')" class="font-semibold text-gray-700" />
                            <select id="subcategory" name="subcategory" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="NONE OF THE ABOVE">NONE OF THE ABOVE</option>
                                <option value="BELOW MINIMUM WAGE EARNER">BELOW MINIMUM WAGE EARNER</option>
                                <option value="NO REGULAR INCOME">NO REGULAR INCOME</option>
                                <option value="INDIGENOUS PEOPLE">INDIGENOUS PEOPLE</option>
                                <option value="SOLO PARENT">SOLO PARENT</option>
                                <option value="4PS BENEFICIARY">4PS BENEFICIARY</option>
                            </select>
                            <x-input-error :messages="$errors->get('subcategory')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="program_requested" :value="__('Source of Fund')" class="font-semibold text-gray-700" />
                            <select id="program_requested" name="program_requested" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="AICS" {{ old('program_requested') == 'AICS' ? 'selected' : '' }}>AICS (Assistance to Individuals in Crisis Situation)</option>
                                <option value="Other" {{ old('program_requested') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('program_requested')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="district" :value="__('District')" class="font-semibold text-gray-700" />
                            <select id="district" name="district" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Lone">Lone</option>
                            </select>
                            <x-input-error :messages="$errors->get('district')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="mode_of_admission" :value="__('Mode of Admission/Service Modality')" class="font-semibold text-gray-700" />
                            <select id="mode_of_admission" name="mode_of_admission" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Walk-in">Walk-in</option>
                                <option value="Offsite">Offsite</option>
                            </select>
                            <x-input-error :messages="$errors->get('mode_of_admission')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="mode_of_release" :value="__('Mode of Release')" class="font-semibold text-gray-700" />
                            <select id="mode_of_release" name="mode_of_release" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Outright Cash">Outright Cash</option>
                            </select>
                            <x-input-error :messages="$errors->get('mode_of_release')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="amount" :value="__('Amount')" class="font-semibold text-gray-700" />
                            <x-text-input id="amount" name="amount" type="number" step="0.01" class="mt-1.5 block w-full" :value="old('amount')" />
                            <x-input-error :messages="$errors->get('amount')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="type_of_assistance" :value="__('Type of Assistance')" class="font-semibold text-gray-700" />
                            <select id="type_of_assistance" name="type_of_assistance" class="mt-1.5 block w-full" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="CASH RELIEF ASSISTANCE" {{ old('type_of_assistance') == 'CASH RELIEF ASSISTANCE' ? 'selected' : '' }}>CASH RELIEF ASSISTANCE</option>
                                <option value="MEDICAL ASSISTANCE" {{ old('type_of_assistance') == 'MEDICAL ASSISTANCE' ? 'selected' : '' }}>MEDICAL ASSISTANCE</option>
                                <option value="FUNERAL ASSISTANCE" {{ old('type_of_assistance') == 'FUNERAL ASSISTANCE' ? 'selected' : '' }}>FUNERAL ASSISTANCE</option>
                            </select>
                            <x-input-error :messages="$errors->get('type_of_assistance')" class="mt-2" />
                        </div>
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
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const municipalitySelect = document.getElementById('municipality');
        const barangaySelect = document.getElementById('barangay');
        const provinceWrapper = provinceSelect.closest('div'); // yung buong <div> ng Province field

        let allProvinces = [];
        let allCitiesMunicipalities = [];

        fetch('https://psgc.cloud/api/regions')
            .then(res => res.json())
            .then(regions => {
                regions
                    .sort((a, b) => a.name.localeCompare(b.name))
                    .forEach(region => {
                        const option = document.createElement('option');
                        option.value = region.name;
                        option.dataset.code = region.code;
                        option.textContent = region.name;
                        regionSelect.appendChild(option);
                    });
            })
            .catch(err => console.error('Failed to load regions:', err));

        fetch('https://psgc.cloud/api/provinces')
            .then(res => res.json())
            .then(data => { allProvinces = data; })
            .catch(err => console.error('Failed to load provinces:', err));

        fetch('https://psgc.cloud/api/cities-municipalities')
            .then(res => res.json())
            .then(data => { allCitiesMunicipalities = data; })
            .catch(err => console.error('Failed to load cities/municipalities:', err));

        regionSelect.addEventListener('change', () => {
            const selectedOption = regionSelect.options[regionSelect.selectedIndex];
            const regionCode = selectedOption.dataset.code;
            const regionName = selectedOption.value;

            municipalitySelect.innerHTML = '<option value="">-- Select Municipality First --</option>';
            barangaySelect.innerHTML = '<option value="">-- Select Municipality First --</option>';
            municipalitySelect.disabled = true;
            barangaySelect.disabled = true;

            if (!regionCode) {
                provinceSelect.innerHTML = '<option value="">-- Select Region First --</option>';
                provinceSelect.disabled = true;
                provinceWrapper.style.display = ''; // ibalik kung natago
                return;
            }

            const regionPrefix = regionCode.substring(0, 2);

            const matchedProvinces = allProvinces
                .filter(p => p.code.substring(0, 2) === regionPrefix)
                .sort((a, b) => a.name.localeCompare(b.name));

            if (matchedProvinces.length === 0) {
                // WALANG PROVINCE sa region na 'to (hal. NCR) — i-skip ang province dropdown
                provinceWrapper.style.display = 'none';
                provinceSelect.innerHTML = `<option value="${regionName}" selected>${regionName}</option>`;
                provinceSelect.disabled = false; // hindi na disabled para masali sa form submit

                // Direktang i-populate ang Municipality galing sa REGION prefix (2 digits)
                const matchedMunicipalities = allCitiesMunicipalities
                    .filter(m => m.code.substring(0, 2) === regionPrefix)
                    .sort((a, b) => a.name.localeCompare(b.name));

                municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';
                matchedMunicipalities.forEach(m => {
                    const option = document.createElement('option');
                    option.value = m.name;
                    option.dataset.code = m.code;
                    option.textContent = m.name;
                    municipalitySelect.appendChild(option);
                });
                municipalitySelect.disabled = false;
            } else {
                // May province ang region na 'to — normal na flow
                provinceWrapper.style.display = '';
                provinceSelect.innerHTML = '<option value="">-- Select Province --</option>';
                matchedProvinces.forEach(p => {
                    const option = document.createElement('option');
                    option.value = p.name;
                    option.dataset.code = p.code;
                    option.textContent = p.name;
                    provinceSelect.appendChild(option);
                });
                provinceSelect.disabled = false;
            }
        });

        provinceSelect.addEventListener('change', () => {
            const selectedOption = provinceSelect.options[provinceSelect.selectedIndex];
            const provinceCode = selectedOption.dataset.code;

            // Kung "walang province" mode (NCR case), wala nang code — huwag nang gawin ito
            if (!provinceCode) return;

            municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';
            barangaySelect.innerHTML = '<option value="">-- Select Municipality First --</option>';
            barangaySelect.disabled = true;

            const provincePrefix = provinceCode.substring(0, 6);

            const matched = allCitiesMunicipalities
                .filter(m => m.code.substring(0, 6) === provincePrefix)
                .sort((a, b) => a.name.localeCompare(b.name));

            matched.forEach(m => {
                const option = document.createElement('option');
                option.value = m.name;
                option.dataset.code = m.code;
                option.textContent = m.name;
                municipalitySelect.appendChild(option);
            });

            municipalitySelect.disabled = false;
        });

        municipalitySelect.addEventListener('change', () => {
            const selectedOption = municipalitySelect.options[municipalitySelect.selectedIndex];
            const municipalityCode = selectedOption.dataset.code;

            barangaySelect.innerHTML = '<option value="">-- Loading... --</option>';
            barangaySelect.disabled = true;

            if (!municipalityCode) return;

            fetch(`https://psgc.cloud/api/cities-municipalities/${municipalityCode}/barangays`)
                .then(res => res.json())
                .then(barangays => {
                    barangaySelect.innerHTML = '<option value="">-- Select Barangay --</option>';
                    barangays
                        .sort((a, b) => a.name.localeCompare(b.name))
                        .forEach(b => {
                            const option = document.createElement('option');
                            option.value = b.name;
                            option.textContent = b.name;
                            barangaySelect.appendChild(option);
                        });
                    barangaySelect.disabled = false;
                })
                .catch(err => console.error('Failed to load barangays:', err));
        });
    });
</script>
@endpush
</x-receptionist-layout>