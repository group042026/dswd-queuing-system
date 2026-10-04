<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Monthly Transaction Report</title>

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
            color: #000000;
            font-size: 6.5px;
            margin: 0;
        }

        .report-header {
            text-align: center;
            margin-bottom: 8px;
        }

        .report-title {
            font-size: 15px;
            font-weight: bold;
            margin: 0 0 3px;
        }

        .report-month {
            font-size: 9px;
            margin: 0;
        }

        .report-summary {
            font-size: 8px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 3px 2px;
            vertical-align: top;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.15;
        }

        th {
            background-color: #ffffff;
            font-size: 6.5px;
            font-weight: bold;
            text-align: center;
            vertical-align: middle;
        }

        td {
            font-size: 6.5px;
        }

        .center {
            text-align: center;
        }

        .amount {
            text-align: right;
        }

        .date {
            text-align: center;
            white-space: nowrap;
        }

        .subcategory {
            font-size: 5.8px;
            white-space: normal;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1 class="report-title">
            Monthly Transaction Report
        </h1>

        <p class="report-month">
            {{ \Carbon\Carbon::parse($selectedMonth . '-01')->format('F Y') }}
        </p>
    </div>

    <div class="report-summary">
        Total Transactions: {{ $transactions->count() }}
    </div>

    <table>
        <colgroup>
            {{-- Excel widths converted to proportional PDF widths --}}
            <col style="width: 6.5%;">
            <col style="width: 4.5%;">
            <col style="width: 6.5%;">
            <col style="width: 9.5%;">
            <col style="width: 7.5%;">
            <col style="width: 8%;">
            <col style="width: 7.5%;">
            <col style="width: 4%;">
            <col style="width: 6%;">
            <col style="width: 6%;">
            <col style="width: 6%;">
            <col style="width: 5%;">
            <col style="width: 3.5%;">
            <col style="width: 5%;">
            <col style="width: 6%;">
            <col style="width: 3%;">
            <col style="width: 7%;">
            <col style="width: 8%;">
            <col style="width: 5%;">
            <col style="width: 7%;">
            <col style="width: 6.5%;">
            <col style="width: 7%;">
            <col style="width: 7%;">
            <col style="width: 6%;">
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
            </tr>
        </thead>

        <tbody>
            @forelse ($transactions as $processing)
                @php
                    $client = $processing->client;
                @endphp

                <tr>
                    <td class="center">
                        {{ $enteredBy }}
                    </td>

                    <td class="center">
                        {{ $client->control_number }}
                    </td>

                    <td class="date">
                        {{ $processing->end_time
                            ? \Carbon\Carbon::parse($processing->end_time)->format('F d, Y')
                            : '' }}
                    </td>

                    <td>
                        {{ $client->region ? strtoupper($client->region) : '' }}
                    </td>

                    <td>
                        {{ $client->province ? strtoupper($client->province) : '' }}
                    </td>

                    <td>
                        {{ $client->municipality ? strtoupper($client->municipality) : '' }}
                    </td>

                    <td>
                        {{ $client->barangay ? strtoupper($client->barangay) : '' }}
                    </td>

                    <td>
                        {{ $client->district ? strtoupper($client->district) : '' }}
                    </td>

                    <td>
                        {{ $client->last_name ? strtoupper($client->last_name) : '' }}
                    </td>

                    <td>
                        {{ $client->first_name ? strtoupper($client->first_name) : '' }}
                    </td>

                    <td>
                        {{ $client->middle_name ? strtoupper($client->middle_name) : '' }}
                    </td>

                    <td>
                        {{ $client->suffix ? strtoupper($client->suffix) : '' }}
                    </td>

                    <td class="center">
                        {{ $client->sex ? strtoupper($client->sex) : '' }}
                    </td>

                    <td class="center">
                        {{ $client->civil_status ? strtoupper($client->civil_status) : '' }}
                    </td>

                    <td class="date">
                        {{ $client->birthdate
                            ? \Carbon\Carbon::parse($client->birthdate)->format('F d, Y')
                            : '' }}
                    </td>

                    <td class="center">
                        {{ $client->age ?? '' }}
                    </td>

                    <td>
                        {{ $client->mode_of_admission ?? '' }}
                    </td>

                    <td>
                        {{ $client->type_of_assistance ?? '' }}
                    </td>

                    <td class="amount">
                        {{ $client->amount !== null
                            ? number_format((float) $client->amount, 2)
                            : '' }}
                    </td>

                    <td>
                        {{ $client->program_requested ?? '' }}
                    </td>

                    <td>
                        {{ $client->mode_of_release ?? '' }}
                    </td>

                    <td>
                        {{ $client->client_category ?? '' }}
                    </td>

                    <td class="subcategory">
                        {{ $client->subcategory ?? '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="24" class="center">
                        No transactions for this month.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>