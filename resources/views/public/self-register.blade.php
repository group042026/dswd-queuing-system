<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Online Pre-Registration - DSWD</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,800&display=swap" rel="stylesheet" />
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
        input:focus, select:focus { outline: none; border-color: #0038a8; }
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
        .error { color: #dc2626; font-size: 12px; margin-top: -10px; margin-bottom: 12px; }
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
        .hint { font-size: 11px; color: #94a3b8; margin-top: -10px; margin-bottom: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>DSWD Online Pre-Registration</h1>
        {{-- <p>Punan ang form para makakuha ng Queue Number bago pumunta sa opisina.</p> --}}
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

        <form method="POST" action="{{ route('public.register.store') }}" enctype="multipart/form-data">
            @csrf

            {{-- Personal Info --}}
            <div class="card">
                <h2>Personal Information</h2>

                <label for="first_name">First Name</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>

                <label for="middle_name">Middle Name</label>
                <input type="text" id="middle_name" name="middle_name" value="{{ old('middle_name') }}">

                <label for="last_name">Last Name</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>

                <label for="suffix">Suffix</label>
                <select id="suffix" name="suffix">
                    <option value="">-- None --</option>
                    <option value="Jr.">Jr.</option>
                    <option value="Sr.">Sr.</option>
                    <option value="II">II</option>
                    <option value="III">III</option>
                    <option value="IV">IV</option>
                </select>

                <label for="sex">Sex</label>
                <select id="sex" name="sex" required>
                    <option value="">-- Select --</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>

                <label for="birthdate">Birthdate</label>
                <input type="date" id="birthdate" name="birthdate" x-data x-model="birthdate" required>

                <label for="age">Age</label>
                <input type="number" id="age" name="age" required>

                <label for="civil_status">Civil Status</label>
                <select id="civil_status" name="civil_status" required>
                    <option value="">-- Select --</option>
                    <option value="Single">Single</option>
                    <option value="Married">Married</option>
                    <option value="Widowed">Widowed</option>
                    <option value="Separated">Separated</option>
                    <option value="Divorced">Divorced</option>
                </select>

                <label for="contact_number">Contact Number</label>
                <input type="text" id="contact_number" name="contact_number" value="{{ old('contact_number') }}" required>
            </div>

            {{-- Address --}}
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
                    <option value="Lone">Lone</option>
                </select>
            </div>

            {{-- Valid ID --}}
            <div class="card">
                <h2>Valid Identification</h2>

                <label for="valid_id_type">Valid ID Type</label>
                <select id="valid_id_type" name="valid_id_type" required>
                    <option value="">-- Select --</option>
                    <option value="Philippine National ID">Philippine National ID</option>
                    <option value="Passport">Passport</option>
                    <option value="Driver's License">Driver's License</option>
                    <option value="Voter's ID">Voter's ID</option>
                    <option value="SSS ID">SSS ID</option>
                    <option value="PhilHealth ID">PhilHealth ID</option>
                    <option value="Barangay ID">Barangay ID</option>
                    <option value="Other">Other</option>
                </select>

                <label for="valid_id_number">Valid ID Number</label>
                <input type="text" id="valid_id_number" name="valid_id_number" required>
                <p class="hint" id="valid_id_number_hint">Select an ID type first</p>

                <label for="id_photo">Upload Photo of ID</label>
                <input type="file" id="id_photo" name="id_photo" accept="image/*" capture="environment" required>
            </div>

            {{-- Assistance Details --}}
            <div class="card">
                <h2>Assistance Details</h2>

                <label for="client_category">Client Category</label>
                <select id="client_category" name="client_category" required>
                    <option value="">-- Select --</option>
                    <option value="Senior Citizens">Senior Citizen</option>
                    <option value="Family heads and Other Needy Adult">Family heads and Other Needy Adult</option>
                    <option value="Youth in Need and Other Needy Adult">Youth in Need and Other Needy Adult</option>
                    <option value="Youth in Need of Special Protection">Youth in Need of Special Protection</option>
                    <option value="Men/Women in specially difficult circumstances">Men/Women in specially difficult circumstances</option>
                </select>

                <label>Subcategory</label>
                <div class="checkbox-group">
                    @foreach(['NONE OF THE ABOVE', 'BELOW MINIMUM WAGE EARNER', 'NO REGULAR INCOME', 'INDIGENOUS PEOPLE', 'SOLO PARENT', '4PS BENEFICIARY'] as $subcategory)
                        <label>
                            <input type="checkbox" name="subcategory[]" value="{{ $subcategory }}">
                            {{ $subcategory }}
                        </label>
                    @endforeach
                </div>

                <label for="program_requested">Source of Fund</label>
                <select id="program_requested" name="program_requested" required>
                    <option value="">-- Select --</option>
                    <option value="AICS">AICS (Assistance to Individuals in Crisis Situation)</option>
                    <option value="Other">Other</option>
                </select>

                <label for="mode_of_release">Mode of Release</label>
                <select id="mode_of_release" name="mode_of_release" required>
                    <option value="">-- Select --</option>
                    <option value="Outright Cash">Outright Cash</option>
                </select>

                <label for="amount">Amount (if known)</label>
                <input type="number" step="0.01" id="amount" name="amount">

                <label for="type_of_assistance">Type of Assistance</label>
                <select id="type_of_assistance" name="type_of_assistance" required>
                    <option value="">-- Select --</option>
                    <option value="CASH RELIEF ASSISTANCE">CASH RELIEF ASSISTANCE</option>
                    <option value="MEDICAL ASSISTANCE">MEDICAL ASSISTANCE</option>
                    <option value="FUNERAL ASSISTANCE">FUNERAL ASSISTANCE</option>
                </select>
            </div>

            {{-- Supporting Documents --}}
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
        // Auto-compute age
        document.getElementById('birthdate').addEventListener('change', function () {
            const birthdate = new Date(this.value);
            const today = new Date();
            let age = today.getFullYear() - birthdate.getFullYear();
            const m = today.getMonth() - birthdate.getMonth();
            if (m < 0 || (m === 0 && today.getDate() < birthdate.getDate())) age--;
            document.getElementById('age').value = age >= 0 ? age : '';
        });

        // Dynamic ID format hint
        const idFormats = {
            'Philippine National ID': { placeholder: 'e.g. 123456789012', hint: '12 digits, no dashes', maxlength: 12 },
            'SSS ID': { placeholder: 'e.g. 12-3456789-0', hint: 'Format: 12-3456789-0', maxlength: 12 },
            'PhilHealth ID': { placeholder: 'e.g. 12-345678901-2', hint: 'Format: 12-345678901-2', maxlength: 14 },
            "Driver's License": { placeholder: 'e.g. N01-12-345678', hint: 'Format: N01-12-345678', maxlength: 11 },
            'Passport': { placeholder: 'e.g. P12345678', hint: '1 letter + 8 digits', maxlength: 9 },
            "Voter's ID": { placeholder: 'Enter ID number', hint: 'No fixed format', maxlength: 20 },
            'Barangay ID': { placeholder: 'Enter ID number', hint: 'Varies per barangay', maxlength: 20 },
            'Other': { placeholder: 'Enter ID number', hint: '', maxlength: 50 },
        };

        document.getElementById('valid_id_type').addEventListener('change', function () {
            const config = idFormats[this.value];
            const input = document.getElementById('valid_id_number');
            const hint = document.getElementById('valid_id_number_hint');
            input.value = '';
            if (config) {
                input.placeholder = config.placeholder;
                input.maxLength = config.maxlength;
                hint.textContent = config.hint;
            }
        });

        // Address cascading (parehong logic sa Receptionist form)
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
                });

            fetch('https://psgc.cloud/api/provinces')
                .then(res => res.json())
                .then(data => { allProvinces = data; });

            fetch('https://psgc.cloud/api/cities-municipalities')
                .then(res => res.json())
                .then(data => { allCitiesMunicipalities = data; });

            regionSelect.addEventListener('change', () => {
                const selectedOption = regionSelect.options[regionSelect.selectedIndex];
                const regionCode = selectedOption.dataset.code;

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
                const matchedProvinces = allProvinces
                    .filter(p => p.code.substring(0, 2) === regionPrefix)
                    .sort((a, b) => a.name.localeCompare(b.name));

                if (matchedProvinces.length === 0) {
                    // NCR-type region — walang province, direktang municipality
                    provinceSelect.innerHTML = `<option value="${selectedOption.value}" selected>${selectedOption.value}</option>`;
                    provinceSelect.disabled = false;

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
                        barangays.sort((a, b) => a.name.localeCompare(b.name)).forEach(b => {
                            const option = document.createElement('option');
                            option.value = b.name;
                            option.textContent = b.name;
                            barangaySelect.appendChild(option);
                        });
                        barangaySelect.disabled = false;
                    });
            });
        });
    </script>
</body>
</html>