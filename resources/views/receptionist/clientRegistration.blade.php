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
        ageError: '',
        computeAge() {
            if (!this.birthdate) { this.age = ''; this.ageError = ''; return; }
            const today = new Date();
            const bd = new Date(this.birthdate);
            let years = today.getFullYear() - bd.getFullYear();
            const m = today.getMonth() - bd.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < bd.getDate())) years--;

            if (years < 0) {
                this.age = '';
                this.ageError = 'Invalid birthdate.';
            } else if (years > 130) {
                this.age = years;
                this.ageError = 'Age must not exceed 130 years.';
            } else {
                this.age = years;
                this.ageError = '';
            }
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

            <div class="mb-6 flex justify-end">
                <button
                    type="button"
                    id="find_returning_client"
                    class="btn-submit"
                    x-data=""
                    x-on:click="$dispatch('open-modal', 'returning-client-modal')"
                >
                    {{ __('Find Previous Client') }}
                </button>
            </div>

            <x-modal name="returning-client-modal" maxWidth="2xl">
                <div class="p-6">
                    <div class="flex items-start justify-between gap-4 border-b pb-4">
                        <div>
                            <h2 class="text-lg font-extrabold text-gray-800">{{ __('Previous Clients') }}</h2>
                            <p class="mt-1 text-sm text-gray-500">{{ __('Only clients with completed transactions are shown.') }}</p>
                        </div>
                        <button type="button" class="text-gray-400 hover:text-gray-700" x-on:click="$dispatch('close-modal', 'returning-client-modal')" aria-label="{{ __('Close') }}">&times;</button>
                    </div>

                    <div class="mt-4 flex gap-2">
                        <input id="returning_client_search" type="search" placeholder="{{ __('Search name or ID number') }}" class="block w-full">
                        <button type="button" id="search_returning_clients" class="btn-submit">{{ __('Search') }}</button>
                    </div>

                    <p id="returning_clients_status" class="mt-3 text-sm text-gray-500"></p>

                    <div class="mt-3 max-h-[55vh] overflow-y-auto rounded-lg border">
                        <table class="min-w-full divide-y divide-gray-200 text-left text-sm">
                            <thead class="sticky top-0 bg-gray-50 text-xs uppercase tracking-wide text-gray-500">
                                <tr>
                                    <th class="px-4 py-3">{{ __('Name') }}</th>
                                    <th class="px-4 py-3">{{ __('Birthday') }}</th>
                                    <th class="px-4 py-3">{{ __('ID Used') }}</th>
                                    <th class="px-4 py-3 text-right">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody id="returning_clients_table" class="divide-y divide-gray-100 bg-white"></tbody>
                        </table>
                    </div>

                    <div class="mt-4 flex justify-end">
                        <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'returning-client-modal')">
                            {{ __('Close') }}
                        </x-secondary-button>
                    </div>
                </div>
            </x-modal>

            <form method="POST" action="{{ route('receptionist.clients.store') }}">
                @csrf

                <input type="hidden" name="returning_client_id" id="returning_client_id">

                
                {{-- SECTION 1: Personal Information --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">1</span>
                        {{ __('Personal Information') }}
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <x-input-label for="first_name" :value="__('First Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="first_name" name="first_name" type="text" class="mt-1.5 block w-full" :value="old('first_name')" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+" required autofocus />
                            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="middle_name" :value="__('Middle Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="middle_name" name="middle_name" type="text" class="mt-1.5 block w-full" :value="old('middle_name')" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+" />
                            <x-input-error :messages="$errors->get('middle_name')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" class="font-semibold text-gray-700" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1.5 block w-full" :value="old('last_name')" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+" required />
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
                            <p class="text-xs text-gray-400 mt-1" x-show="!ageError">{{ __('Auto-computed from birthdate') }}</p>
                            <p class="text-xs text-red-500 mt-1 font-semibold" x-show="ageError" x-text="ageError"></p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
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

                {{-- SECTION 4: Valid ID --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">3</span>
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
                                <option value="UMID ID" {{ old('valid_id_type') == 'UMID ID' ? 'selected' : '' }}>UMID ID</option>
                                <option value="GSIS ID" {{ old('valid_id_type') == 'GSIS ID' ? 'selected' : '' }}>GSIS ID</option>
                                <option value="PRC ID" {{ old('valid_id_type') == 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                                <option value="OWWA/OFW ID" {{ old('valid_id_type') == 'OWWA/OFW ID' ? 'selected' : '' }}>OWWA/OFW ID</option>
                                <option value="DOLE ID" {{ old('valid_id_type') == 'DOLE ID' ? 'selected' : '' }}>DOLE ID</option>
                                <option value="Postal ID" {{ old('valid_id_type') == 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                                <option value="NBI Clearance" {{ old('valid_id_type') == 'NBI Clearance' ? 'selected' : '' }}>NBI Clearance</option>
                                <option value="BI Clearance" {{ old('valid_id_type') == 'BI Clearance' ? 'selected' : '' }}>BI Clearance</option>
                                <option value="Police Clearance" {{ old('valid_id_type') == 'Police Clearance' ? 'selected' : '' }}>Police Clearance</option>
                                <option value="4Ps ID" {{ old('valid_id_type') == '4Ps ID' ? 'selected' : '' }}>4Ps ID</option>
                                <option value="PWD ID" {{ old('valid_id_type') == 'PWD ID' ? 'selected' : '' }}>PWD ID</option>
                                <option value="Solo Parent ID" {{ old('valid_id_type') == 'Solo Parent ID' ? 'selected' : '' }}>Solo Parent ID</option>
                                <option value="City/Municipal ID" {{ old('valid_id_type') == 'City/Municipal ID' ? 'selected' : '' }}>City/Municipal ID</option>
                                <option value="OSCA ID (Senior Citizen)" {{ old('valid_id_type') == 'OSCA ID (Senior Citizen)' ? 'selected' : '' }}>OSCA ID (Senior Citizen)</option>
                                <option value="LSWDO/MSWDO ID" {{ old('valid_id_type') == 'LSWDO/MSWDO ID' ? 'selected' : '' }}>LSWDO/MSWDO ID</option>
                                <option value="DSWD Certification" {{ old('valid_id_type') == 'DSWD Certification' ? 'selected' : '' }}>DSWD Certification</option>
                                <option value="PSA Document" {{ old('valid_id_type') == 'PSA Document' ? 'selected' : '' }}>PSA Document</option>
                                <option value="Pag-IBIG ID" {{ old('valid_id_type') == 'Pag-IBIG ID' ? 'selected' : '' }}>Pag-IBIG ID</option>
                                <option value="Barangay ID" {{ old('valid_id_type') == 'Barangay ID' ? 'selected' : '' }}>Barangay ID</option>
                                {{-- <option value="Other" {{ old('valid_id_type') == 'Other' ? 'selected' : '' }}>Other</option> --}}
                            </select>
                            <x-input-error :messages="$errors->get('valid_id_type')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="valid_id_number" :value="__('Valid ID Number')" class="font-semibold text-gray-700" />
                            <x-text-input
                                id="valid_id_number"
                                name="valid_id_number"
                                type="text"
                                inputmode="text"
                                class="mt-1.5 block w-full"
                                :value="old('valid_id_number')"
                                required
                            />
                            <p class="text-xs text-gray-400 mt-1" id="valid_id_number_hint">{{ __('Select an ID type first') }}</p>
                            <x-input-error :messages="$errors->get('valid_id_number')" class="mt-2" />
                        </div>

                    </div>
                </div>

                {{-- SECTION 5: Assistance Details --}}
                <div class="reg-card">
                    <h3 class="reg-card__title">
                        <span class="reg-card__title-number">4</span>
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
                            <x-input-label :value="__('Subcategory')" class="font-semibold text-gray-700" />
                            <div class="mt-1.5 space-y-2 border border-gray-300 rounded-md p-3">
                                @php
                                    $subcategories = [
                                        'NONE OF THE ABOVE',
                                        'BELOW MINIMUM WAGE EARNER',
                                        'NO REGULAR INCOME',
                                        'INDIGENOUS PEOPLE',
                                        'SOLO PARENT',
                                        '4PS BENEFICIARY',
                                    ];
                                    $oldSubcategories = old('subcategory', []);
                                @endphp

                                @foreach($subcategories as $subcategory)
                                    <label class="flex items-center gap-2 text-sm text-gray-700">
                                        <input
                                            type="checkbox"
                                            name="subcategory[]"
                                            value="{{ $subcategory }}"
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                            {{ in_array($subcategory, $oldSubcategories) ? 'checked' : '' }}
                                        >
                                        {{ $subcategory }}
                                    </label>
                                @endforeach
                            </div>
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

                        <div>
                            <x-input-label
                                for="service_modality"
                                :value="__('Service Modality')"
                                class="font-semibold text-gray-700"
                            />

                            <select
                                id="service_modality"
                                name="service_modality"
                                class="mt-1.5 block w-full"
                                required
                            >
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Walk-in" {{ old('service_modality') == 'Walk-in' ? 'selected' : '' }}>
                                    Walk-in
                                </option>
                                <option value="Offsite" {{ old('service_modality') == 'Offsite' ? 'selected' : '' }}>
                                    Offsite
                                </option>
                            </select>

                            <x-input-error
                                :messages="$errors->get('service_modality')"
                                class="mt-2"
                            />
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

        let barangayRequestId = 0;

        municipalitySelect.addEventListener('change', () => {
            const requestId = ++barangayRequestId; // bagong request, pinaka-bago
            const selectedOption = municipalitySelect.options[municipalitySelect.selectedIndex];
            const municipalityCode = selectedOption.dataset.code;

            barangaySelect.innerHTML = '<option value="">-- Loading... --</option>';
            barangaySelect.disabled = true;

            if (!municipalityCode) return;

            fetch(`https://psgc.cloud/api/cities-municipalities/${municipalityCode}/barangays`)
                .then(res => res.json())
                .then(barangays => {
                    if (requestId !== barangayRequestId) return; // luma na 'to, i-ignore

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

        const idTypeSelect = document.getElementById('valid_id_type');
        const idNumberInput = document.getElementById('valid_id_number');
        const idNumberHint = document.getElementById('valid_id_number_hint');

        const findReturningClientButton = document.getElementById('find_returning_client');
        const returningClientMessage = document.getElementById('returning_clients_status');

        // ---- Search modal: Find Previous Client ----
        const searchInput = document.getElementById('returning_client_search');
        const searchButton = document.getElementById('search_returning_clients');
        const resultsTable = document.getElementById('returning_clients_table');
        const resultsStatus = document.getElementById('returning_clients_status');
        const returningClientIdInput = document.getElementById('returning_client_id');

        function searchReturningClients() {
            const search = searchInput.value.trim();

            resultsStatus.textContent = 'Searching...';
            resultsTable.innerHTML = '';

            fetch(`{{ route('receptionist.clients.returning') }}?search=${encodeURIComponent(search)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to search clients.');
                    }
                    return response.json();
                })
                .then(data => {
                    const clients = data.clients || [];

                    if (clients.length === 0) {
                        resultsStatus.textContent = 'No matching clients found.';
                        return;
                    }

                    resultsStatus.textContent = `${clients.length} client(s) found.`;

                    clients.forEach(client => {
                        const fullName = [client.first_name, client.middle_name, client.last_name, client.suffix]
                            .filter(Boolean)
                            .join(' ');

                        const row = document.createElement('tr');
                        row.innerHTML = `
                            <td class="px-4 py-3">${fullName}</td>
                            <td class="px-4 py-3">${client.birthdate ?? ''}</td>
                            <td class="px-4 py-3">${client.valid_id_type ?? ''}: ${client.valid_id_number ?? ''}</td>
                            <td class="px-4 py-3 text-right">
                                <button type="button" class="btn-submit select-returning-client">
                                    {{ __('Use') }}
                                </button>
                            </td>
                        `;

                        row.querySelector('.select-returning-client').addEventListener('click', () => {
                            fillReturningClient(client);
                        });

                        resultsTable.appendChild(row);
                    });
                })
                .catch(error => {
                    console.error(error);
                    resultsStatus.textContent = 'An error occurred while searching.';
                });
        }

        function fillReturningClient(client) {
            returningClientIdInput.value = client.id;

            document.getElementById('first_name').value = client.first_name ?? '';
            document.getElementById('middle_name').value = client.middle_name ?? '';
            document.getElementById('last_name').value = client.last_name ?? '';
            document.getElementById('suffix').value = client.suffix ?? '';
            document.getElementById('sex').value = client.sex ?? '';
            document.getElementById('civil_status').value = client.civil_status ?? '';
            document.getElementById('contact_number').value = client.contact_number ?? '';
            document.getElementById('valid_id_type').value = client.valid_id_type ?? '';
            idTypeSelect.dispatchEvent(new Event('change'));
            document.getElementById('valid_id_number').value = client.valid_id_number ?? '';
            document.getElementById('district').value = client.district ?? '';
            document.getElementById('client_category').value = client.client_category ?? '';

            const savedSubcategories = (client.subcategory ?? '')
                .split(',')
                .map(s => s.trim())
                .filter(Boolean);

            document.querySelectorAll('input[name="subcategory[]"]').forEach(checkbox => {
                checkbox.checked = savedSubcategories.includes(checkbox.value);
            });
            // --- FIX: Birthdate ---
            const birthdateInput = document.getElementById('birthdate');
            if (client.birthdate) {
                // Kunin lang yung "YYYY-MM-DD" part, kahit ano pa format galing sa backend
                birthdateInput.value = client.birthdate.substring(0, 10);

                // 'input' event -> para ma-sync si Alpine's x-model="birthdate"
                birthdateInput.dispatchEvent(new Event('input', { bubbles: true }));
                // 'change' event -> para ma-trigger yung x-on:change="computeAge()"
                birthdateInput.dispatchEvent(new Event('change', { bubbles: true }));
            }

            // --- Cascading location fill ---
            fillLocationCascade(client);

            window.dispatchEvent(new CustomEvent('close-modal', { detail: 'returning-client-modal' }));
        }

        searchButton.addEventListener('click', searchReturningClients);

        // Para pag pinindot yung Enter key sa search box, mag-search din agad
        searchInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                searchReturningClients();
            }
        });

        findReturningClientButton.addEventListener('click', () => {
            const validIdType = idTypeSelect.value;
            const validIdNumber = idNumberInput.value;
            const birthdate = document.getElementById('birthdate').value;

            if (!validIdType || !validIdNumber || !birthdate) {
                returningClientMessage.textContent = 'search existing client';
                returningClientMessage.className = 'mt-2 text-sm text-red-500';
                return;
            }

            returningClientMessage.textContent = 'Searching...';
            returningClientMessage.className = 'mt-2 text-sm text-gray-500';

            fetch(`{{ route('receptionist.clients.returning') }}?valid_id_type=${encodeURIComponent(validIdType)}&valid_id_number=${encodeURIComponent(validIdNumber)}&birthdate=${encodeURIComponent(birthdate)}`)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to find returning client.');
                    }

                    return response.json();
                })
                .then(data => {
                    if (data.found) {
                        returningClientMessage.textContent = 'Returning client found.';
                        returningClientMessage.className = 'mt-2 text-sm text-green-600';

                        console.log('Returning client:', data);
                    } else {
                        returningClientMessage.textContent = 'No previous client found.';
                        returningClientMessage.className = 'mt-2 text-sm text-red-500';
                    }
                })
                .catch(error => {
                    console.error(error);

                    returningClientMessage.textContent = 'An error occurred while searching for the client.';
                    returningClientMessage.className = 'mt-2 text-sm text-red-500';
                });
        });

        function waitFor(conditionFn, callback, attempts = 0) {
            if (conditionFn()) {
                callback();
                return;
            }
            if (attempts > 50) { 
                console.warn('waitFor: timed out waiting for condition.');
                return;
            }
            setTimeout(() => waitFor(conditionFn, callback, attempts + 1), 100);
        }

        function normalizeLocationName(value) {
            return (value ?? '')
                .toString()
                .trim()                          // para umayos yung mga munisipal namay space tulad ng Baler "
                .toLowerCase()
                .replace(/\s*\(.*?\)\s*/g, '');  // extra safety kung may (Capital) suffix sa ibang lugar
        }

        function selectOptionByValue(selectEl, value) {
            if (!value) return false;

            const target = normalizeLocationName(value);

            const match = Array.from(selectEl.options).find(
                opt => normalizeLocationName(opt.value) === target
            );

            if (match) {
                selectEl.value = match.value; // gamitin yung ACTUAL option value (may space pa rin, "Baler ")
                return true;
            }

            return false;
        }

        function fillLocationCascade(client) {
            // console.log('Client address data:', {
            //     region: client.region,
            //     province: client.province,
            //     municipality: client.municipality,
            //     barangay: client.barangay,
            // });
        regionSelect.value = '';
        provinceSelect.value = '';
        municipalitySelect.innerHTML = '<option value="">-- Loading... --</option>';
        barangaySelect.innerHTML = '<option value="">-- Loading... --</option>';
        municipalitySelect.disabled = true;
        barangaySelect.disabled = true;

        if (!client.region && !client.province && !client.municipality && !client.barangay) {
            municipalitySelect.innerHTML = '<option value="">-- Select Province First --</option>';
            barangaySelect.innerHTML = '<option value="">-- Select Municipality First --</option>';
            return;
        }

        waitFor(
            
            () => regionSelect.options.length > 1,
            () => {
                if (!selectOptionByValue(regionSelect, client.region)) return;
                regionSelect.dispatchEvent(new Event('change'));

                waitFor(
                    () => !provinceSelect.disabled,
                    () => {
                        const provinceHasOptions = provinceSelect.options.length > 1;

                        if (provinceHasOptions) {
                            if (!selectOptionByValue(provinceSelect, client.province)) return;
                            provinceSelect.dispatchEvent(new Event('change'));
                        }

                        waitFor(
                            () => !municipalitySelect.disabled && municipalitySelect.options.length > 1,
                            () => {

                                // console.log('Available municipalities:', Array.from(municipalitySelect.options).map(o => o.value));
                                // console.log('Looking for:', client.municipality);
                                if (!selectOptionByValue(municipalitySelect, client.municipality)) return;
                                municipalitySelect.dispatchEvent(new Event('change'));

                                waitFor(
                                    () => !barangaySelect.disabled && barangaySelect.options.length > 1,
                                    () => {
                                        selectOptionByValue(barangaySelect, client.barangay);
                                    }
                                );
                            }
                        );
                    }
                );
            }
        );
    }

        const idFormats = {
            'Philippine National ID': {
                pattern: '\\d{12}',
                maxlength: 12,
                placeholder: 'e.g. 123456789012',
                hint: '12 digits, no dashes',
            },
            'SSS ID': {
                pattern: '\\d{2}-\\d{7}-\\d{1}',
                maxlength: 12,
                placeholder: 'e.g. 12-3456789-0',
                hint: 'Format: 12-3456789-0',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 10);

                    if (digits.length <= 2) {
                        return digits;
                    }

                    if (digits.length <= 9) {
                        return `${digits.slice(0, 2)}-${digits.slice(2)}`;
                    }

                    return `${digits.slice(0, 2)}-${digits.slice(2, 9)}-${digits.slice(9)}`;
                },
            },
            'PhilHealth ID': {
                pattern: '\\d{2}-\\d{9}-\\d{1}',
                maxlength: 14,
                placeholder: 'e.g. 12-345678901-2',
                hint: 'Format: 12-345678901-2',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 12);

                    if (digits.length <= 2) {
                        return digits;
                    }

                    if (digits.length <= 11) {
                        return `${digits.slice(0, 2)}-${digits.slice(2)}`;
                    }

                    return `${digits.slice(0, 2)}-${digits.slice(2, 11)}-${digits.slice(11)}`;
                },
            },
            "Driver's License": {
                pattern: '[A-Za-z]\\d{2}-\\d{2}-\\d{6}',
                maxlength: 13,
                placeholder: 'e.g. N01-12-345678',
                hint: 'Format: N01-12-345678',
                format: value => {
                    const cleaned = value
                        .toUpperCase()
                        .replace(/[^A-Z0-9]/g, '');

                    const letter = cleaned.match(/^[A-Z]/)?.[0] ?? '';
                    const digits = cleaned
                        .slice(letter ? 1 : 0)
                        .replace(/\D/g, '')
                        .slice(0, 10);

                    if (!letter) {
                        return '';
                    }

                    if (digits.length <= 2) {
                        return `${letter}${digits}`;
                    }

                    if (digits.length <= 4) {
                        return `${letter}${digits.slice(0, 2)}-${digits.slice(2)}`;
                    }

                    return `${letter}${digits.slice(0, 2)}-${digits.slice(2, 4)}-${digits.slice(4)}`;
                },
            },
            'Passport': {
                pattern: '[A-Za-z]\\d{8}',
                maxlength: 9,
                placeholder: 'e.g. P12345678',
                hint: '1 letter followed by 8 digits',
            },
            "Voter's ID": {
                pattern: '.{1,20}',
                maxlength: 20,
                placeholder: 'Enter Voter\'s ID number',
                hint: 'No fixed format',
            },
            'Barangay ID': {
                pattern: '.{1,20}',
                maxlength: 20,
                placeholder: 'Enter Barangay ID number',
                hint: 'Varies per barangay',
            },
            'UMID ID': {
                pattern: '\\d{4}-\\d{7}-\\d{1}',
                maxlength: 14,
                placeholder: 'e.g. 1234-5678901-2',
                hint: 'Format: 1234-5678901-2 (CRN)',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 12);
                    if (digits.length <= 4) return digits;
                    if (digits.length <= 11) return `${digits.slice(0, 4)}-${digits.slice(4)}`;
                    return `${digits.slice(0, 4)}-${digits.slice(4, 11)}-${digits.slice(11)}`;
                },
            },
            'GSIS ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            'PRC ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            'OWWA/OFW ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            'DOLE ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            'Postal ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            'NBI Clearance': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter clearance number', hint: 'No fixed format' },
            'BI Clearance': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter clearance number', hint: 'No fixed format' },
            'Police Clearance': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter clearance number', hint: 'No fixed format' },
            '4Ps ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter Household ID number', hint: 'No fixed format' },
            'PWD ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'Varies per LGU' },
            'Solo Parent ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'Varies per LGU' },
            'City/Municipal ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'Varies per LGU' },
            'OSCA ID (Senior Citizen)': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'Varies per LGU' },
            'LSWDO/MSWDO ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'Varies per office' },
            'DSWD Certification': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter reference number', hint: 'No fixed format' },
            'PSA Document': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter document number', hint: 'No fixed format' },
            'Pag-IBIG ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' },
            // 'Other': {
            //     pattern: '.{1,20}',
            //     maxlength: 20,
            //     placeholder: 'Enter ID number',
            //     hint: 'No specific format required',
            // },
        };

        let selectedIdFormat = null;

        idTypeSelect.addEventListener('change', () => {
            const selected = idTypeSelect.value;
            selectedIdFormat = idFormats[selected];

            idNumberInput.value = '';

            if (!selectedIdFormat) {
                idNumberInput.removeAttribute('pattern');
                idNumberInput.removeAttribute('maxlength');
                idNumberInput.placeholder = '';
                idNumberHint.textContent = 'Select an ID type first';

                return;
            }

            idNumberInput.setAttribute('pattern', selectedIdFormat.pattern);
            idNumberInput.setAttribute('maxlength', selectedIdFormat.maxlength);
            idNumberInput.placeholder = selectedIdFormat.placeholder;
            idNumberHint.textContent = selectedIdFormat.hint;
        });

        idNumberInput.addEventListener('input', () => {
            if (selectedIdFormat?.format) {
                idNumberInput.value = selectedIdFormat.format(idNumberInput.value);
            }
        });

        function restrictToLetters(input) {
            if (!input) return;
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^A-Za-zÑñ\s\-'.]/g, '');
            });
        }

        restrictToLetters(document.getElementById('first_name'));
        restrictToLetters(document.getElementById('middle_name'));
        restrictToLetters(document.getElementById('last_name'));
    });
</script>
@endpush
</x-receptionist-layout>