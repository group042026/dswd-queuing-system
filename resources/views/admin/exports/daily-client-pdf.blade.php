<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daily Client Report</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 12px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 7px;
            color: #000;
            margin: 0;
        }

        .header {
            margin-bottom: 10px;
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin: 0;
        }

        .subtitle {
            font-size: 9px;
            margin-top: 4px;
        }

        .summary {
            font-size: 8px;
            margin-bottom: 8px;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th, td {
            border: 1px solid #000;
            padding: 4px 3px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background: #ffffff;
            font-size: 7px;
            font-weight: bold;
            text-align: center;
            line-height: 1.1;
        }

        td {
            font-size: 7px;
            line-height: 1.2;
        }

        .center {
            text-align: center;
        }

        .nowrap {
            white-space: nowrap;
        }

        .amount {
            text-align: right;
        }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('images/dswd-logo.png');
        $logoBase64 = file_exists($logoPath) ? 'data:image/png;base64,' . base64_encode(file_get_contents($logoPath)) : '';
    @endphp

    <table style="width: 100%; border: none; margin-bottom: 8px; border-collapse: collapse;">
        <tr>
            <td style="width: 75px; border: none; text-align: left; vertical-align: middle; padding: 0;">
                @if($logoBase64)
                    <img src="{{ $logoBase64 }}" style="height: 48px; width: auto;" alt="DSWD Logo">
                @endif
            </td>
            <td style="border: none; text-align: center; vertical-align: middle; padding: 0 10px;">
                <div style="font-size: 8px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; color: #1e293b;">Republic of the Philippines</div>
                <div style="font-size: 11px; font-weight: 900; text-transform: uppercase; color: #0038a8; margin: 1px 0;">Department of Social Welfare and Development</div>
                <div style="font-size: 8px; font-weight: 600; color: #475569;">Crisis Intervention Section (CIS) • Assistance to Individuals in Crisis Situation (AICS)</div>
                <div style="font-size: 7px; color: #64748b; margin-top: 1px;">Queuing Management & Appointment System • Official Audit Report</div>
            </td>
            <td style="width: 85px; border: none; text-align: right; vertical-align: middle; padding: 0;">
                <div style="font-size: 7px; color: #64748b; line-height: 1.2; text-align: right;">
                    <strong>DSWD-QMS</strong><br>
                    <span>Generated: {{ now()->format('M d, Y') }}</span><br>
                    <span>Time: {{ now()->format('h:i A') }}</span>
                </div>
            </td>
        </tr>
    </table>
    <div style="border-bottom: 2px solid #0038a8; margin-bottom: 10px; width: 100%;"></div>

    <div class="header">
        <div class="title">Daily Client Report</div>
        <div class="subtitle">{{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}</div>
    </div>

    <div class="summary">
        Total Clients: {{ $clients->count() }}
    </div>

    <table>
        <colgroup>
            <col style="width: 8%;">
            <col style="width: 6%;">
            <col style="width: 8%;">
            <col style="width: 9%;">
            <col style="width: 8%;">
            <col style="width: 9%;">
            <col style="width: 8%;">
            <col style="width: 4%;">
            <col style="width: 8%;">
            <col style="width: 8%;">
            <col style="width: 8%;">
            <col style="width: 6%;">
            <col style="width: 4%;">
            <col style="width: 6%;">
            <col style="width: 8%;">
            <col style="width: 4%;">
            <col style="width: 8%;">
            <col style="width: 11%;">
            <col style="width: 7%;">
            <col style="width: 9%;">
            <col style="width: 8%;">
            <col style="width: 9%;">
            <col style="width: 9%;">
            <col style="width: 9%;">
            <col style="width: 7%;">
        </colgroup>

        <thead>
            <tr>
                <th>Entered By</th>
                <th>Client No.</th>
                <th>Date of Assistance</th>
                <th>Region</th>
                <th>Province</th>
                <th>City/Municipality</th>
                <th>Barangay</th>
                <th>District</th>
                <th>Last Name</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Extra Name</th>
                <th>Sex</th>
                <th>Civil Status</th>
                <th>DOB</th>
                <th>Age</th>
                <th>Mode of Admission</th>
                <th>Type of Assistance</th>
                <th>Amount</th>
                <th>Source of Fund</th>
                <th>Mode of Release</th>
                <th>Client Category</th>
                <th>Subcategory</th>
                <th>Service Modality</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($clients as $client)
                <tr>
                    <td class="center">{{ auth()->user()->first_name }} {{ auth()->user()->last_name }}</td>
                    <td class="center">{{ $client->control_number }}</td>
                    <td class="center nowrap">{{ $client->date_registered ? \Carbon\Carbon::parse($client->date_registered)->format('M d, Y') : '' }}</td>
                    <td>{{ $client->region ? strtoupper($client->region) : '' }}</td>
                    <td>{{ $client->province ? strtoupper($client->province) : '' }}</td>
                    <td>{{ $client->municipality ? strtoupper($client->municipality) : '' }}</td>
                    <td>{{ $client->barangay ? strtoupper($client->barangay) : '' }}</td>
                    <td class="center">{{ $client->district ? strtoupper($client->district) : '' }}</td>
                    <td>{{ $client->last_name ? strtoupper($client->last_name) : '' }}</td>
                    <td>{{ $client->first_name ? strtoupper($client->first_name) : '' }}</td>
                    <td>{{ $client->middle_name ? strtoupper($client->middle_name) : '' }}</td>
                    <td>{{ $client->suffix ? strtoupper($client->suffix) : '' }}</td>
                    <td class="center">{{ $client->sex ? strtoupper($client->sex) : '' }}</td>
                    <td class="center">{{ $client->civil_status ? strtoupper($client->civil_status) : '' }}</td>
                    <td class="center nowrap">{{ $client->birthdate ? \Carbon\Carbon::parse($client->birthdate)->format('M d, Y') : '' }}</td>
                    <td class="center">{{ $client->age ?? '' }}</td>
                    <td>{{ $client->mode_of_admission ?? '' }}</td>
                    <td>{{ $client->type_of_assistance ?? '' }}</td>
                    <td class="amount">{{ $client->amount ? number_format((float) $client->amount, 2) : '' }}</td>
                    <td>{{ $client->program_requested ?? '' }}</td>
                    <td>{{ $client->mode_of_release ?? '' }}</td>
                    <td>{{ $client->client_category ?? '' }}</td>
                    <td>{{ $client->subcategory ?? '' }}</td>
                    {{-- <td class="center">{{ $client->occupation ?? '' }}</td> --}}
                    <td>{{ $client->service_modality ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="25" class="center">No clients registered on this date.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>