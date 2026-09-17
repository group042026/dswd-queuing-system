<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Pre-Registration - DSWD</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />

```
<style>
    * { box-sizing: border-box; }

    body {
        font-family: 'Figtree', sans-serif;
        background: #f1f5f9;
        margin: 0;
        padding-bottom: 40px;
    }

    .header {
        background: linear-gradient(135deg, #0038a8 0%, #1e40af 60%, #ce1126 100%);
        color: white;
        padding: 20px 16px;
    }

    .header h1 { font-size: 18px; font-weight: 800; margin: 0 0 4px; }
    .header p { font-size: 12px; opacity: 0.85; margin: 0; }

    .track-link {
        display: inline-block;
        margin-top: 10px;
        font-size: 12px;
        color: white;
        text-decoration: underline;
    }

    .container { padding: 16px; max-width: 480px; margin: 0 auto; }

    .card {
        background: white;
        border-radius: 12px;
        padding: 16px;
        margin-bottom: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .card h2 {
        font-size: 13px;
        font-weight: 800;
        color: #0038a8;
        text-transform: uppercase;
        letter-spacing: 0.03em;
        margin: 0 0 12px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 4px;
    }

    input, select, textarea {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        margin-bottom: 14px;
        font-family: inherit;
    }

    input:focus, select:focus {
        outline: none;
        border-color: #0038a8;
    }

    .checkbox-group {
        border: 1.5px solid #cbd5e1;
        border-radius: 8px;
        padding: 10px 12px;
        margin-bottom: 14px;
    }

    .checkbox-group label {
        display: flex;
        align-items: center;
        gap: 8px;
        font-weight: 500;
        margin-bottom: 6px;
    }

    .checkbox-group input[type="checkbox"] { width: auto; margin: 0; }

    .error {
        color: #dc2626;
        font-size: 12px;
        margin-top: -10px;
        margin-bottom: 12px;
    }

    .btn-submit {
        display: block;
        width: 100%;
        background: #0038a8;
        color: white;
        font-weight: 700;
        font-size: 15px;
        padding: 14px;
        border-radius: 10px;
        border: none;
        cursor: pointer;
    }

    .hint {
        font-size: 11px;
        color: #94a3b8;
        margin-top: -10px;
        margin-bottom: 12px;
    }

    .age-error {
        display: none;
        font-size: 12px;
        color: #dc2626;
        font-weight: 600;
        margin-top: -10px;
        margin-bottom: 12px;
    }

    .age-error.show { display: block; }

    .input-invalid {
        border-color: #dc2626 !important;
        background-color: #fef2f2 !important;
    }
</style>
```

</head>

    <body>
        <div class="header">
            <h1>DSWD Online Pre-Registration</h1>
            <p>Please fill up the form to receive your Queue Number</p>
            <a href="{{ route('public.track') }}" class="track-link">Already registered? Track your application →</a>
        </div>

        <div class="container">
            @if($errors->any())
                <div class="card" style="border: 1px solid #fecaca; background: #fef2f2;">
                    <p style="font-size: 13px; color: #b91c1c; font-weight: 600; margin: 0 0 6px;">Please fix the following:</p>
                    <ul style="font-size: 12px; color: #b91c1c; margin: 0; padding-left: 18px;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('public.register.store') }}" enctype="multipart/form-data" id="registrationForm">
                @csrf

                <div class="card">
                    <h2>Personal Information</h2>

                    <label for="first_name">First Name</label>
                    <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+" required>

                    <label for="middle_name">Middle Name</label>
                    <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+">

                    <label for="last_name">Last Name</label>
                    <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" maxlength="50" pattern="[A-Za-zÑñ\s\-'.]+" required>

                    <label for="suffix">Suffix</label>
                    <select id="suffix" name="suffix">
                        <option value="">-- None --</option>
                        <option value="Jr." {{ old('suffix') === 'Jr.' ? 'selected' : '' }}>Jr.</option>
                        <option value="Sr." {{ old('suffix') === 'Sr.' ? 'selected' : '' }}>Sr.</option>
                        <option value="II" {{ old('suffix') === 'II' ? 'selected' : '' }}>II</option>
                        <option value="III" {{ old('suffix') === 'III' ? 'selected' : '' }}>III</option>
                        <option value="IV" {{ old('suffix') === 'IV' ? 'selected' : '' }}>IV</option>
                    </select>

                    <label for="sex">Sex</label>
                    <select id="sex" name="sex" required>
                        <option value="">-- Select --</option>
                        <option value="Male" {{ old('sex') === 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('sex') === 'Female' ? 'selected' : '' }}>Female</option>
                    </select>

                    <label for="birthdate">Birthdate</label>
                    <input type="date" id="birthdate" name="birthdate" value="{{ old('birthdate') }}" required>

                    <label for="age">Age</label>
                    <input type="number" id="age" name="age" value="{{ old('age') }}" readonly required style="background-color: #f1f5f9; color: #64748b;">
                    <p class="hint" id="ageHint">Automatically computed from birthdate</p>
                    <p class="age-error" id="ageError"></p>

                    <label for="civil_status">Civil Status</label>
                    <select id="civil_status" name="civil_status" required>
                        <option value="">-- Select --</option>
                        <option value="Single" {{ old('civil_status') === 'Single' ? 'selected' : '' }}>Single</option>
                        <option value="Married" {{ old('civil_status') === 'Married' ? 'selected' : '' }}>Married</option>
                        <option value="Widowed" {{ old('civil_status') === 'Widowed' ? 'selected' : '' }}>Widowed</option>
                        <option value="Separated" {{ old('civil_status') === 'Separated' ? 'selected' : '' }}>Separated</option>
                        <option value="Divorced" {{ old('civil_status') === 'Divorced' ? 'selected' : '' }}>Divorced</option>
                    </select>

                    <label for="contact_number">Contact Number</label>
                    <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
                </div>

                <div class="card">
                    <h2>Address</h2>

                    <label for="region">Region</label>
                    <select id="region" name="region" required>
                        <option value="">-- Select Region --</option>
                    </select>

                    <label for="province">Province</label>
                    <select id="province" name="province" required disabled>
                        <option value="">-- Select Region First --</option>
                    </select>

                    <label for="municipality">Municipality/City</label>
                    <select id="municipality" name="municipality" required disabled>
                        <option value="">-- Select Province First --</option>
                    </select>

                    <label for="barangay">Barangay</label>
                    <select id="barangay" name="barangay" required disabled>
                        <option value="">-- Select Municipality First --</option>
                    </select>

                    <label for="district">District</label>
                    <select id="district" name="district" required>
                        <option value="">-- Select --</option>
                        <option value="Lone" {{ old('district') === 'Lone' ? 'selected' : '' }}>Lone</option>
                    </select>
                </div>

                <div class="card">
                    <h2>Valid Identification</h2>

                    <label for="valid_id_type">Valid ID Type</label>
                    <select id="valid_id_type" name="valid_id_type" required>
                        <option value="">-- Select --</option>
                        <option value="Philippine National ID" {{ old('valid_id_type') === 'Philippine National ID' ? 'selected' : '' }}>Philippine National ID</option>
                        <option value="Passport" {{ old('valid_id_type') === 'Passport' ? 'selected' : '' }}>Passport</option>
                        <option value="Driver's License" {{ old('valid_id_type') === "Driver's License" ? 'selected' : '' }}>Driver's License</option>
                        <option value="Voter's ID" {{ old('valid_id_type') === "Voter's ID" ? 'selected' : '' }}>Voter's ID</option>
                        <option value="SSS ID" {{ old('valid_id_type') === 'SSS ID' ? 'selected' : '' }}>SSS ID</option>
                        <option value="PhilHealth ID" {{ old('valid_id_type') === 'PhilHealth ID' ? 'selected' : '' }}>PhilHealth ID</option>
                        <option value="UMID ID" {{ old('valid_id_type') === 'UMID ID' ? 'selected' : '' }}>UMID ID</option>
                        <option value="GSIS ID" {{ old('valid_id_type') === 'GSIS ID' ? 'selected' : '' }}>GSIS ID</option>
                        <option value="PRC ID" {{ old('valid_id_type') === 'PRC ID' ? 'selected' : '' }}>PRC ID</option>
                        <option value="OWWA/OFW ID" {{ old('valid_id_type') === 'OWWA/OFW ID' ? 'selected' : '' }}>OWWA/OFW ID</option>
                        <option value="DOLE ID" {{ old('valid_id_type') === 'DOLE ID' ? 'selected' : '' }}>DOLE ID</option>
                        <option value="Postal ID" {{ old('valid_id_type') === 'Postal ID' ? 'selected' : '' }}>Postal ID</option>
                        <option value="NBI Clearance" {{ old('valid_id_type') === 'NBI Clearance' ? 'selected' : '' }}>NBI Clearance</option>
                        <option value="BI Clearance" {{ old('valid_id_type') === 'BI Clearance' ? 'selected' : '' }}>BI Clearance</option>
                        <option value="Police Clearance" {{ old('valid_id_type') === 'Police Clearance' ? 'selected' : '' }}>Police Clearance</option>
                        <option value="4Ps ID" {{ old('valid_id_type') === '4Ps ID' ? 'selected' : '' }}>4Ps ID</option>
                        <option value="PWD ID" {{ old('valid_id_type') === 'PWD ID' ? 'selected' : '' }}>PWD ID</option>
                        <option value="Solo Parent ID" {{ old('valid_id_type') === 'Solo Parent ID' ? 'selected' : '' }}>Solo Parent ID</option>
                        <option value="City/Municipal ID" {{ old('valid_id_type') === 'City/Municipal ID' ? 'selected' : '' }}>City/Municipal ID</option>
                        <option value="OSCA ID (Senior Citizen)" {{ old('valid_id_type') === 'OSCA ID (Senior Citizen)' ? 'selected' : '' }}>OSCA ID (Senior Citizen)</option>
                        <option value="LSWDO/MSWDO ID" {{ old('valid_id_type') === 'LSWDO/MSWDO ID' ? 'selected' : '' }}>LSWDO/MSWDO ID</option>
                        <option value="DSWD Certification" {{ old('valid_id_type') === 'DSWD Certification' ? 'selected' : '' }}>DSWD Certification</option>
                        <option value="PSA Document" {{ old('valid_id_type') === 'PSA Document' ? 'selected' : '' }}>PSA Document</option>
                        <option value="Pag-IBIG ID" {{ old('valid_id_type') === 'Pag-IBIG ID' ? 'selected' : '' }}>Pag-IBIG ID</option>
                        <option value="Barangay ID" {{ old('valid_id_type') === 'Barangay ID' ? 'selected' : '' }}>Barangay ID</option>
                    </select>

                    <label for="valid_id_number">Valid ID Number</label>
                    <input type="text" id="valid_id_number" name="valid_id_number" required>
                    <p class="hint" id="valid_id_number_hint">Select an ID type first</p>

                    <label for="id_photo">Upload Photo of ID</label>
                    <input type="file" id="id_photo" name="id_photo" accept="image/*" capture="environment" required>
                </div>

                <div class="card">
                    <h2>Assistance Details</h2>

                    <label for="client_category">Client Category</label>
                    <select id="client_category" name="client_category" required>
                        <option value="">-- Select --</option>
                        <option value="Senior Citizens" {{ old('client_category') === 'Senior Citizens' ? 'selected' : '' }}>Senior Citizen</option>
                        <option value="Family heads and Other Needy Adult" {{ old('client_category') === 'Family heads and Other Needy Adult' ? 'selected' : '' }}>Family heads and Other Needy Adult</option>
                        <option value="Youth in Need and Other Needy Adult" {{ old('client_category') === 'Youth in Need and Other Needy Adult' ? 'selected' : '' }}>Youth in Need and Other Needy Adult</option>
                        <option value="Youth in Need of Special Protection" {{ old('client_category') === 'Youth in Need of Special Protection' ? 'selected' : '' }}>Youth in Need of Special Protection</option>
                        <option value="Men/Women in specially difficult circumstances" {{ old('client_category') === 'Men/Women in specially difficult circumstances' ? 'selected' : '' }}>Men/Women in specially difficult circumstances</option>
                    </select>

                    <label>Subcategory</label>
                    <div class="checkbox-group">
                        @foreach(['NONE OF THE ABOVE', 'BELOW MINIMUM WAGE EARNER', 'NO REGULAR INCOME', 'INDIGENOUS PEOPLE', 'SOLO PARENT', '4PS BENEFICIARY'] as $subcategory)
                            <label><input type="checkbox" name="subcategory[]" value="{{ $subcategory }}">{{ $subcategory }}</label>
                        @endforeach
                    </div>

                    <label for="program_requested">Source of Fund</label>
                    <select id="program_requested" name="program_requested" required>
                        <option value="">-- Select --</option>
                        <option value="AICS" {{ old('program_requested') === 'AICS' ? 'selected' : '' }}>AICS (Assistance to Individuals in Crisis Situation)</option>
                        <option value="Other" {{ old('program_requested') === 'Other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <label for="mode_of_release">Mode of Release</label>
                    <select id="mode_of_release" name="mode_of_release" required>
                        <option value="">-- Select --</option>
                        <option value="Outright Cash" {{ old('mode_of_release') === 'Outright Cash' ? 'selected' : '' }}>Outright Cash</option>
                    </select>

                    <label for="amount">Amount (if known)</label>
                    <input type="number" step="0.01" id="amount" name="amount" value="{{ old('amount') }}">

                    <label for="type_of_assistance">Type of Assistance</label>
                    <select id="type_of_assistance" name="type_of_assistance" required>
                        <option value="">-- Select --</option>
                        <option value="CASH RELIEF ASSISTANCE" {{ old('type_of_assistance') === 'CASH RELIEF ASSISTANCE' ? 'selected' : '' }}>CASH RELIEF ASSISTANCE</option>
                        <option value="MEDICAL ASSISTANCE" {{ old('type_of_assistance') === 'MEDICAL ASSISTANCE' ? 'selected' : '' }}>MEDICAL ASSISTANCE</option>
                        <option value="FUNERAL ASSISTANCE" {{ old('type_of_assistance') === 'FUNERAL ASSISTANCE' ? 'selected' : '' }}>FUNERAL ASSISTANCE</option>
                    </select>
                </div>

                <div class="card">
                    <h2>Supporting Documents (Optional)</h2>
                    <label for="other_documents">Upload additional documents</label>
                    <input type="file" id="other_documents" name="other_documents[]" accept="image/*" multiple>
                    <p class="hint">e.g. Barangay Certificate, Income Certificate</p>
                </div>

                <button type="submit" class="btn-submit">Submit Pre-Registration</button>
            </form>
        </div>

    <script>
        const birthdateInput = document.getElementById('birthdate');
        const ageInput = document.getElementById('age');
        const ageHint = document.getElementById('ageHint');
        const ageError = document.getElementById('ageError');
        const registrationForm = document.getElementById('registrationForm');

        let ageIsInvalid = false;

        function computeAge() {
            const birthdateValue = birthdateInput.value;

            ageIsInvalid = false;
            ageError.textContent = '';
            ageError.classList.remove('show');
            birthdateInput.classList.remove('input-invalid');
            ageInput.classList.remove('input-invalid');
            ageHint.style.display = '';

            if (!birthdateValue) {
                ageInput.value = '';
                return;
            }

            const [year, month, day] = birthdateValue.split('-').map(Number);
            const today = new Date();
            const birthdate = new Date(year, month - 1, day);

            let years = today.getFullYear() - birthdate.getFullYear();
            const currentMonth = today.getMonth();
            const birthMonth = birthdate.getMonth();

            if (currentMonth < birthMonth || (currentMonth === birthMonth && today.getDate() < birthdate.getDate())) {
                years--;
            }

            if (birthdate > today) {
                ageInput.value = '';
                ageError.textContent = 'Invalid birthdate.';
                ageError.classList.add('show');
                birthdateInput.classList.add('input-invalid');
                ageHint.style.display = 'none';
                ageIsInvalid = true;
                return;
            }

            if (years > 130) {
                ageInput.value = years;
                ageError.textContent = 'Age must not exceed 130 years.';
                ageError.classList.add('show');
                birthdateInput.classList.add('input-invalid');
                ageInput.classList.add('input-invalid');
                ageHint.style.display = 'none';
                ageIsInvalid = true;
                return;
            }

            ageInput.value = years;
            ageError.textContent = '';
            ageError.classList.remove('show');
            birthdateInput.classList.remove('input-invalid');
            ageInput.classList.remove('input-invalid');
            ageHint.style.display = '';
            ageIsInvalid = false;
        }

        birthdateInput.addEventListener('change', computeAge);
        birthdateInput.addEventListener('input', computeAge);
        computeAge();

        registrationForm.addEventListener('submit', function (event) {
            computeAge();

            if (ageIsInvalid) {
                event.preventDefault();
                ageError.scrollIntoView({ behavior: 'smooth', block: 'center' });
                birthdateInput.focus();
            }
        });

        const idFormats = {
            'Philippine National ID': { pattern: '\\d{12}', maxlength: 12, placeholder: 'e.g. 123456789012', hint: '12 digits, no dashes' },
            'SSS ID': {
                pattern: '\\d{2}-\\d{7}-\\d{1}',
                maxlength: 12,
                placeholder: 'e.g. 12-3456789-0',
                hint: 'Format: 12-3456789-0',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 10);
                    if (digits.length <= 2) return digits;
                    if (digits.length <= 9) return `${digits.slice(0, 2)}-${digits.slice(2)}`;
                    return `${digits.slice(0, 2)}-${digits.slice(2, 9)}-${digits.slice(9)}`;
                }
            },
            'PhilHealth ID': {
                pattern: '\\d{2}-\\d{9}-\\d{1}',
                maxlength: 14,
                placeholder: 'e.g. 12-345678901-2',
                hint: 'Format: 12-345678901-2',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 12);
                    if (digits.length <= 2) return digits;
                    if (digits.length <= 11) return `${digits.slice(0, 2)}-${digits.slice(2)}`;
                    return `${digits.slice(0, 2)}-${digits.slice(2, 11)}-${digits.slice(11)}`;
                }
            },
            "Driver's License": {
                pattern: '[A-Za-z]\\d{2}-\\d{2}-\\d{6}',
                maxlength: 13,
                placeholder: 'e.g. N01-12-345678',
                hint: 'Format: N01-12-345678',
                format: value => {
                    const cleaned = value.toUpperCase().replace(/[^A-Z0-9]/g, '');
                    const letter = cleaned.match(/^[A-Z]/)?.[0] ?? '';
                    const digits = cleaned.slice(letter ? 1 : 0).replace(/\D/g, '').slice(0, 10);
                    if (!letter) return '';
                    if (digits.length <= 2) return `${letter}${digits}`;
                    if (digits.length <= 4) return `${letter}${digits.slice(0, 2)}-${digits.slice(2)}`;
                    return `${letter}${digits.slice(0, 2)}-${digits.slice(2, 4)}-${digits.slice(4)}`;
                }
            },
            'Passport': { pattern: '[A-Za-z]\\d{8}', maxlength: 9, placeholder: 'e.g. P12345678', hint: '1 letter followed by 8 digits' },
            "Voter's ID": { pattern: '.{1,20}', maxlength: 20, placeholder: "Enter Voter's ID number", hint: 'No fixed format' },
            'Barangay ID': { pattern: '.{1,20}', maxlength: 20, placeholder: 'Enter Barangay ID number', hint: 'Varies per barangay' },
            'UMID ID': {
                pattern: '\\d{4}-\\d{7}-\\d{1}',
                maxlength: 14,
                placeholder: 'e.g. 1234-5678901-2',
                hint: 'Format: 1234-5678901-2',
                format: value => {
                    const digits = value.replace(/\D/g, '').slice(0, 12);
                    if (digits.length <= 4) return digits;
                    if (digits.length <= 11) return `${digits.slice(0, 4)}-${digits.slice(4)}`;
                    return `${digits.slice(0, 4)}-${digits.slice(4, 11)}-${digits.slice(11)}`;
                }
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
            'Pag-IBIG ID': { pattern: '.{1,17}', maxlength: 17, placeholder: 'Enter ID number', hint: 'No fixed format' }
        };

        const idTypeSelect = document.getElementById('valid_id_type');
        const idNumberInput = document.getElementById('valid_id_number');
        const idNumberHint = document.getElementById('valid_id_number_hint');

        idTypeSelect.addEventListener('change', function () {
            const config = idFormats[this.value];
            idNumberInput.value = '';

            if (!config) {
                idNumberInput.removeAttribute('pattern');
                idNumberInput.removeAttribute('maxlength');
                idNumberInput.placeholder = '';
                idNumberHint.textContent = 'Select an ID type first';
                return;
            }

            idNumberInput.setAttribute('pattern', config.pattern);
            idNumberInput.setAttribute('maxlength', config.maxlength);
            idNumberInput.placeholder = config.placeholder;
            idNumberHint.textContent = config.hint;
        });

        idNumberInput.addEventListener('input', function () {
            const config = idFormats[idTypeSelect.value];
            if (config?.format) {
                this.value = config.format(this.value);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const regionSelect = document.getElementById('region');
            const provinceSelect = document.getElementById('province');
            const municipalitySelect = document.getElementById('municipality');
            const barangaySelect = document.getElementById('barangay');

            let allProvinces = [];
            let allCitiesMunicipalities = [];

            fetch('https://psgc.cloud/api/regions')
                .then(res => res.json())
                .then(regions => {
                    regions.sort((a, b) => a.name.localeCompare(b.name)).forEach(region => {
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
                    return;
                }

                const regionPrefix = regionCode.substring(0, 2);

                const matchedProvinces = allProvinces.filter(p => p.code.substring(0, 2) === regionPrefix).sort((a, b) => a.name.localeCompare(b.name));

                if (matchedProvinces.length === 0) {
                    provinceSelect.innerHTML = `<option value="${regionName}" selected>${regionName}</option>`;
                    provinceSelect.disabled = false;

                    const matchedMunicipalities = allCitiesMunicipalities.filter(m => m.code.substring(0, 2) === regionPrefix).sort((a, b) => a.name.localeCompare(b.name));

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

                if (!provinceCode) return;

                municipalitySelect.innerHTML = '<option value="">-- Select Municipality --</option>';
                barangaySelect.innerHTML = '<option value="">-- Select Municipality First --</option>';
                barangaySelect.disabled = true;

                const provincePrefix = provinceCode.substring(0, 6);

                const matched = allCitiesMunicipalities.filter(m => m.code.substring(0, 6) === provincePrefix).sort((a, b) => a.name.localeCompare(b.name));

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

                        barangays.sort((a, b) => a.name.localeCompare(b.name)).forEach(b => {
                            const option = document.createElement('option');
                            option.value = b.name;
                            option.textContent = b.name;
                            barangaySelect.appendChild(option);
                        });

                        barangaySelect.disabled = false;
                    })
                    .catch(err => console.error('Failed to load barangays:', err));
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


</body>
</html>
