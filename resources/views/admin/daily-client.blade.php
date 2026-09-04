<x-admin-layout>

    <style>
        /* ==========================================================================
           1. Theme Variables
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

            --emerald-green: #047857;
            --emerald-light: #ecfdf5;
            --emerald-border: #a7f3d0;

            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .dark .client-filter-card,
        .dark .client-report-card {
            border-color: #334155;
        }

        .dark .client-filter-label {
            color: #94a3b8;
        }

        .dark .client-filter-input {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }

        .dark .client-report-card__header {
            border-bottom-color: #334155;
        }

        .dark .client-report-card__date {
            color: #f8fafc;
        }

        .dark .client-report-card__count {
            color: #94a3b8;
        }

        .dark .client-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .dark .client-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .client-table tr:hover td {
            background-color: rgba(30, 64, 175, 0.05);
        }

        .dark .client-empty {
            color: #94a3b8 !important;
        }

        .daily-client {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .daily-client__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .client-header {
            background: linear-gradient(
                135deg,
                var(--dswd-blue) 0%,
                #1e40af 50%,
                var(--dswd-red) 100%
            );
            border-radius: 16px;
            overflow: hidden;
            color: var(--text-white);
            padding: 24px;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .client-header__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .client-header__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .client-header__title {
            font-size: 26px;
            font-weight: 850;
            margin: 0 0 6px 0;
        }

        .client-header__subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            margin: 0;
        }

        .client-filter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .client-filter-form {
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .client-filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .client-filter-label {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
        }

        .client-filter-input {
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            outline: none;
            transition: var(--transition-smooth);
        }

        .client-filter-input:focus {
            border-color: var(--dswd-blue);
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.12);
        }

        .client-btn-view {
            background-color: var(--dswd-blue);
            color: var(--text-white);
            font-weight: 700;
            font-size: 13px;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            transition: var(--transition-smooth);
        }

        .client-btn-view:hover {
            background-color: var(--dswd-blue-hover);
        }

        .client-btn-export {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            background-color: var(--dswd-red);
            color: var(--text-white);
            font-weight: 700;
            font-size: 13px;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .client-btn-export:hover {
            background-color: var(--dswd-red-hover);
        }

        .client-report-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: 4px solid var(--dswd-blue);
            overflow: hidden;
        }

        .client-report-card__header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .client-report-card__date {
            font-weight: 700;
            color: #1e293b;
        }

        .client-report-card__count {
            font-size: 12px;
            font-weight: 700;
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 5px 10px;
            border-radius: 9999px;
        }

        .client-table-wrapper {
            overflow-x: auto;
        }

        .client-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .client-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .client-table td {
            padding: 15px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
            white-space: nowrap;
        }

        .client-table tr:hover td {
            background-color: rgba(0, 56, 168, 0.015);
        }

        .client-control-number {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco,
                Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 13px;
            font-weight: 800;
            color: var(--dswd-blue);
            white-space: nowrap;
        }

        .client-queue-number {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco,
                Consolas, "Liberation Mono", "Courier New", monospace;
            font-size: 13px;
            font-weight: 800;
            color: #334155;
            white-space: nowrap;
        }

        .client-name {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
            white-space: nowrap;
        }

        .dark .client-name {
            color: #e2e8f0;
        }

        .client-category {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .client-subcategory {
            font-size: 13px;
            line-height: 1.4;
            white-space: normal;
            max-width: 220px;
        }

        .client-subcategory--multiple {
            font-size: 11px;
        }

        .category-badge--senior {
            color: #1d4ed8;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .category-badge--family-heads {
            color: #047857;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .category-badge--youth-needy-adult {
            color: #7e22ce;
            background-color: #faf5ff;
            border: 1px solid #e9d5ff;
        }

        .category-badge--youth-protection {
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }

        .category-badge--difficult-circumstances {
            color: #c2410c;
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
        }

        .category-badge--default {
            color: #475569;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
        }

        .client-program {
            /* min-width: 200px; */
            max-width: 300px;
            font-size: 13px;
            color: #475569;
            font-weight: 600;
            line-height: 1.45;
        }

        .dark .client-program {
            color: #94a3b8;
        }

        .client-contact,
        .client-barangay {
            font-size: 13px;
            color: #475569;
            white-space: nowrap;
        }

        .dark .client-contact,
        .dark .client-barangay {
            color: #94a3b8;
        }

        .client-date {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            white-space: nowrap;
        }

        .dark .client-date {
            color: #94a3b8;
        }

        .client-empty {
            padding: 48px 24px !important;
            text-align: center;
            color: #94a3b8 !important;
            font-weight: 600 !important;
        }

        @media (max-width: 640px) {
            .daily-client__container {
                padding: 0 16px;
            }
            .client-header {
                padding: 20px;
            }
            .client-header__title {
                font-size: 22px;
            }
            .client-filter-card {
                padding: 16px;
            }
            .client-filter-form {
                align-items: stretch;
                flex-direction: column;
            }
            .client-btn-view,
            .client-btn-export {
                width: 100%;
                justify-content: center;
                text-align: center;
            }

            .client-report-card__header {
                padding: 16px;
            }

            .client-table th,
            .client-table td {
                padding: 12px 16px;
            }
        }
    </style>

    <div class="daily-client">
        <div class="daily-client__container">
            <div class="client-header">
                {{-- <div class="client-header__bg-icon">
                    <svg width="240" height="240" fill="currentColor" viewBox="0 0 24 24">
                        <path
                            d="M19 3H5c-1.1 0-2 .9-2 2v14
                            c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5
                            c0-1.1-.9-2-2-2zm-2 12h-3v3h-2v-3H9v-2h3v-3h2v3h3v2z"
                        />
                    </svg>
                </div> --}}
                <div>
                    <p class="client-header__badge"> DSWD Operations Control Hub </p>
                    <h1 class="client-header__title"> Daily Client Report </h1>
                    <p class="client-header__subtitle"> Review and export the daily client registration report </p>
                </div>
            </div>
            <div class="client-filter-card">
                <form method="GET" action="{{ route('admin.daily-client') }}" class="client-filter-form">
                    <div class="client-filter-group">
                        <label for="date" class="client-filter-label">
                            {{ __('Select Report Date') }}
                        </label>
                        <input id="date" name="date" type="date" class="client-filter-input" value="{{ $selectedDate }}" />
                    </div>
                    <button type="submit" class="client-btn-view" >
                        {{ __('View Report') }}
                    </button>
                    <a href="{{ route('admin.daily-client.export', ['date' => $selectedDate]) }}" class="client-btn-export">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7
                                a2 2 0 01-2-2V5a2 2 0 012-2h5.586
                                a1 1 0 01.707.293l4.414 4.414
                                A1 1 0 0118 8.414V19a2 2 0 01-2 2z"
                            />
                        </svg>
                        {{ __('Download Excel') }}
                    </a>
                </form>
            </div>
            <div class="client-report-card">
                <div class="client-report-card__header">
                    <div>
                        {{ __('Showing report for:') }}
                        <span class="client-report-card__date">
                            {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                        </span>
                    </div>
                    <div class="client-report-card__count">
                        {{ $clients->count() }}
                        {{ __('clients') }}
                    </div>
                </div>
                <div class="client-table-wrapper" style="overflow-x: auto;">
                    <table class="client-table">
                        <thead>
                            <tr>
                                <th>Client Number</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Suffix</th>
                                <th>Sex</th>
                                <th>Birthdate</th>
                                <th>Age</th>
                                <th>Civil Status</th>
                                <th>Barangay</th>
                                <th>District</th>
                                <th>Mode of Admission</th>
                                <th>Mode of Release</th>
                                <th>Municipality</th>
                                <th>Province</th>
                                <th>Region</th>
                                <th>Contact Number</th>
                                <th>Occupation</th>
                                <th>Salary</th>
                                <th>Household Size</th>
                                <th>Client Category</th>
                                <th>Subcategory</th>
                                <th>Amount</th>
                                <th>Source of Fund</th>
                                <th>Type of Assistance</th>
                                <th>Date Registered</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($clients as $client)
                                @php
                                    $categoryClass = match($client->client_category) {
                                        'Senior Citizens'
                                            => 'category-badge--senior',
                                        'Family heads and Other Needy Adult'
                                            => 'category-badge--family-heads',
                                        'Youth in Need and Other Needy Adult'
                                            => 'category-badge--youth-needy-adult',
                                        'Youth in Need of Special Protection'
                                            => 'category-badge--youth-protection',
                                        'Men/Women in specially difficult circumstances'
                                            => 'category-badge--difficult-circumstances',
                                        default
                                            => 'category-badge--default',
                                    };
                                @endphp
                                <tr>
                                    <td><span class="client-control-number">{{ $client->control_number }}</span></td>
                                    <td>{{ $client->first_name }}</td>
                                    <td>{{ $client->middle_name }}</td>
                                    <td>{{ $client->last_name }}</td>
                                    <td>{{ $client->suffix }}</td>
                                    <td>{{ $client->sex }}</td>
                                    <td>{{ $client->birthdate ? \Carbon\Carbon::parse($client->birthdate)->format('M d, Y') : '—' }}</td>
                                    <td>{{ $client->age }}</td>
                                    <td>{{ $client->civil_status }}</td>
                                    <td>{{ $client->barangay }}</td>
                                    <td>{{ $client->district }}</td>
                                    <td>{{ $client->mode_of_admission }}</td>
                                    <td>{{ $client->mode_of_release }}</td>
                                    <td>{{ $client->municipality }}</td>
                                    <td>{{ $client->province }}</td>
                                    <td>{{ $client->region }}</td>
                                    <td>{{ $client->contact_number }}</td>
                                    <td>{{ $client->occupation }}</td>
                                    <td>{{ $client->salary ? number_format($client->salary, 2) : '—' }}</td>
                                    <td>{{ $client->household_size }}</td>
                                    <td><span class="client-category {{ $categoryClass }}">{{ $client->client_category }}</span></td>
                                    <td class="client-subcategory {{ str_contains($client->subcategory ?? '', ',') ? 'client-subcategory--multiple' : '' }}">
                                        @foreach (explode(', ', $client->subcategory ?? '') as $subcategory)
                                            {{ $subcategory }}@if (!$loop->last),<br>@endif
                                        @endforeach
                                    </td>
                                    <td>{{ $client->amount ? number_format($client->amount, 2) : '—' }}</td>
                                    <td>{{ $client->program_requested }}</td>
                                    <td>{{ $client->type_of_assistance }}</td>
                                    <td>
                                        <span class="client-date">
                                            {{ \Carbon\Carbon::parse($client->date_registered)->format('M d, Y h:i A') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="28" class="client-empty">
                                        {{ __('No clients registered on this date.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>