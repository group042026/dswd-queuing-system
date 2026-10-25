<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Client Processing Report</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 16px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #000000;
            font-size: 8px;
            margin: 0;
        }

        .report-header {
            text-align: center;
            margin-bottom: 10px;
        }

        .report-title {
            font-size: 17px;
            font-weight: bold;
            margin: 0 0 4px;
        }

        .report-period {
            font-size: 10px;
            margin: 0;
        }

        .report-summary {
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 5px 4px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.2;
        }

        th {
            background-color: #ffffff;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
        }

        td {
            font-size: 8px;
        }

        .center {
            text-align: center;
        }

        .date {
            text-align: center;
            white-space: nowrap;
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

    <div class="report-header">
        <h1 class="report-title">
            Client Processing Report
        </h1>

        <p class="report-period">
            {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
            —
            {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </p>
    </div>

    <div class="report-summary">
        Total Processing Records: {{ $processingHistory->count() }}
    </div>

    <table>
        <colgroup>
            <col style="width: 13%;">
            <col style="width: 20%;">
            <col style="width: 13%;">
            <col style="width: 13%;">
            <col style="width: 19%;">
            <col style="width: 16%;">
            <col style="width: 16%;">
        </colgroup>

        <thead>
            <tr>
                <th>Queue Number</th>
                <th>Client Name</th>
                <th>Step</th>
                <th>Status</th>
                <th>Handled By</th>
                <th>Start Time</th>
                <th>End Time</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($processingHistory as $processing)
                <tr>
                    <td class="center">
                        {{ $processing->queue->queue_number ?? '—' }}
                    </td>

                    <td>
                        {{ $processing->client->first_name ?? '' }}
                        {{ $processing->client->last_name ?? '' }}
                    </td>

                    <td class="center">
                        {{ $processing->current_step }}
                    </td>

                    <td class="center">
                        {{ $processing->current_status }}
                    </td>

                    <td>
                        @if ($processing->user)
                            {{ $processing->user->first_name }}
                            {{ $processing->user->last_name }}
                        @else
                            —
                        @endif
                    </td>

                    <td class="date">
                        {{ $processing->start_time
                            ? \Carbon\Carbon::parse($processing->start_time)->format('F d, Y h:i A')
                            : '—' }}
                    </td>

                    <td class="date">
                        {{ $processing->end_time
                            ? \Carbon\Carbon::parse($processing->end_time)->format('F d, Y h:i A')
                            : '—' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="center">
                        No processing records for this date range.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>