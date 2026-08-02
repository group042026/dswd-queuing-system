<x-receptionist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Registration') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="{
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

            {{-- Success message --}}
            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('receptionist.clients.store') }}">
                @csrf

                {{-- SECTION 1: Personal Information --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Personal Information') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
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

                        <div>
                            <x-input-label for="last_name" :value="__('Last Name')" />
                            <x-text-input id="last_name" name="last_name" type="text" class="mt-1 block w-full" :value="old('last_name')" required />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">
                        <div>
                            <x-input-label for="suffix" :value="__('Suffix')" />
                            <select id="suffix" name="suffix" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
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
                            <x-input-label for="sex" :value="__('Sex')" />
                            <select id="sex" name="sex" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                            <x-input-error :messages="$errors->get('sex')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="birthdate" :value="__('Birthdate')" />
                            <x-text-input
                                id="birthdate"
                                name="birthdate"
                                type="date"
                                class="mt-1 block w-full"
                                x-model="birthdate"
                                x-on:change="computeAge()"
                                :value="old('birthdate')"
                                required
                            />
                            <x-input-error :messages="$errors->get('birthdate')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="age" :value="__('Age')" />
                            <x-text-input
                                id="age"
                                name="age"
                                type="number"
                                class="mt-1 block w-full bg-gray-50"
                                x-model="age"
                                readonly
                            />
                            <p class="text-xs text-gray-400 mt-1">{{ __('Auto-computed from birthdate') }}</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mt-4">

                        <div>
                            <x-input-label for="civil_status" :value="__('Civil Status')" />
                            <select id="civil_status" name="civil_status" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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
                            <x-input-label for="email" :value="__('Email (Optional)')" />
                            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email')" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="occupation" :value="__('Occupation')" />
                            <x-text-input id="occupation" name="occupation" type="text" class="mt-1 block w-full" :value="old('occupation')" />
                            <x-input-error :messages="$errors->get('occupation')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="contact_number" :value="__('Contact Number')" />
                            <x-text-input id="contact_number" name="contact_number" type="text" class="mt-1 block w-full" :value="old('contact_number')" />
                            <x-input-error :messages="$errors->get('contact_number')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 2: Address --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Address') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <x-input-label for="barangay" :value="__('Barangay')" />
                            <x-text-input id="barangay" name="barangay" type="text" class="mt-1 block w-full" :value="old('barangay')" required />
                            <x-input-error :messages="$errors->get('barangay')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="municipality" :value="__('Municipality')" />
                            <x-text-input id="municipality" name="municipality" type="text" class="mt-1 block w-full" :value="old('municipality')" required />
                            <x-input-error :messages="$errors->get('municipality')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="province" :value="__('Province')" />
                            <x-text-input id="province" name="province" type="text" class="mt-1 block w-full" :value="old('province')" required />
                            <x-input-error :messages="$errors->get('province')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 3: Household & Financial Background --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Household & Financial Background') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="monthly_income" :value="__('Monthly Income')" />
                            <x-text-input id="monthly_income" name="monthly_income" type="number" step="0.01" class="mt-1 block w-full" :value="old('monthly_income')" required />
                            <x-input-error :messages="$errors->get('monthly_income')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="household_size" :value="__('Household Size')" />
                            <x-text-input id="household_size" name="household_size" type="number" min="1" class="mt-1 block w-full" :value="old('household_size')" required />
                            <x-input-error :messages="$errors->get('household_size')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 4: Valid ID --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Valid Identification') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="valid_id_type" :value="__('Valid ID Type')" />
                            <select id="valid_id_type" name="valid_id_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
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
                            <x-input-label for="valid_id_number" :value="__('Valid ID Number')" />
                            <x-text-input id="valid_id_number" name="valid_id_number" type="text" class="mt-1 block w-full" :value="old('valid_id_number')" required />
                            <x-input-error :messages="$errors->get('valid_id_number')" class="mt-2" />
                        </div>
                    </div>
                </div>

                {{-- SECTION 5: Assistance Details --}}
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                    <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Assistance Details') }}</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="client_category" :value="__('Client Category')" />
                            <select id="client_category" name="client_category" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="Senior" {{ old('client_category') == 'Senior' ? 'selected' : '' }}>Senior Citizen</option>
                                <option value="PWD" {{ old('client_category') == 'PWD' ? 'selected' : '' }}>PWD</option>
                                <option value="Solo Parent" {{ old('client_category') == 'Solo Parent' ? 'selected' : '' }}>Solo Parent</option>
                                <option value="Regular" {{ old('client_category') == 'Regular' ? 'selected' : '' }}>Regular</option>
                            </select>
                            <x-input-error :messages="$errors->get('client_category')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="program_requested" :value="__('Program Requested')" />
                            <select id="program_requested" name="program_requested" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                <option value="">-- {{ __('Select') }} --</option>
                                <option value="AICS" {{ old('program_requested') == 'AICS' ? 'selected' : '' }}>AICS (Assistance to Individuals in Crisis Situation)</option>
                                <option value="Other" {{ old('program_requested') == 'Other' ? 'selected' : '' }}>Other</option>
                            </select>
                            <x-input-error :messages="$errors->get('program_requested')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label for="reason_for_assistance" :value="__('Reason for Assistance')" />
                        <textarea id="reason_for_assistance" name="reason_for_assistance" rows="4"
                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                            required>{{ old('reason_for_assistance') }}</textarea>
                        <x-input-error :messages="$errors->get('reason_for_assistance')" class="mt-2" />
                    </div>
                </div>

                {{-- Action buttons --}}
                <div class="flex justify-end gap-3 mb-10">
                    <a href="{{ route('receptionist.dashboard') }}">
                        <x-secondary-button type="button">
                            {{ __('Cancel') }}
                        </x-secondary-button>
                    </a>
                    <x-primary-button type="submit">
                        {{ __('Register Client') }}
                    </x-primary-button>
                </div>

            </form>
        </div>
    </div>
</x-receptionist-layout>