<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <title>Queue Performance Report</title>

    <style>
        @page {
            size: A4 landscape;
            margin: 18px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            color: #000;
            font-size: 9px;
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
            border: 1px solid #000;
            padding: 6px 5px;
            vertical-align: middle;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        th {
            background-color: #ffffff;
            font-size: 8px;
            font-weight: bold;
            text-align: center;
            line-height: 1.2;
        }

        td {
            font-size: 8px;
            line-height: 1.25;
        }

        .center {
            text-align: center;
        }

        .date {
            text-align: center;
            white-space: nowrap;
        }

        .duration {
            text-align: center;
            white-space: nowrap;
        }

        .status {
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="report-header">
        <h1 class="report-title">
            Queue Performance Report
        </h1>

        <p class="report-period">
            {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }}
            —
            {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
        </p>
    </div>

    <div class="report-summary">
        Total Queues: {{ $queues->count() }}
    </div>

    <table>
        <colgroup>
            <col style="width: 13%;">
            <col style="width: 18%;">
            <col style="width: 19%;">
            <col style="width: 9%;">
            <col style="width: 13%;">
            <col style="width: 12%;">
            <col style="width: 13%;">
            <col style="width: 14%;">
        </colgroup>

        <thead>
            <tr>
                <th>Queue Number</th>
                <th>Client Name</th>
                <th>Client Category</th>
                <th>Priority</th>
                <th>Queue Status</th>
                <th>Total Duration</th>
                <th>Current Step</th>
                <th>Date Issued</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($queues as $queue)
                @php
                    $duration = 'In Progress';

                    if ($queue->queue_status === 'Abandoned') {
                        $duration = 'Abandoned';
                    } elseif (
                        in_array($queue->queue_status, ['Completed', 'Cancelled'])
                        && $queue->latestProcessing?->end_time
                    ) {
                        $duration = \Carbon\Carbon::parse($queue->date_issued)
                            ->diffForHumans(
                                $queue->latestProcessing->end_time,
                                true
                            );
                    }
                @endphp

                <tr>
                    <td class="center">
                        {{ $queue->queue_number }}
                    </td>

                    <td>
                        {{ $queue->client->first_name ?? '' }}
                        {{ $queue->client->last_name ?? '' }}
                    </td>

                    <td>
                        {{ $queue->client->client_category ?? '' }}
                    </td>

                    <td class="center">
                        {{ $queue->priority ? 'Yes' : 'No' }}
                    </td>

                    <td class="status">
                        {{ $queue->queue_status }}
                    </td>

                    <td class="duration">
                        {{ $duration }}
                    </td>

                    <td>
                        {{ $queue->latestProcessing->current_step ?? '—' }}
                    </td>

                    <td class="date">
                        {{ $queue->date_issued
                            ? \Carbon\Carbon::parse($queue->date_issued)->format('F d, Y')
                            : '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="center">
                        No queues for this date range.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>