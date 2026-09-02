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
            --dswd-yellow-light: rgba(252, 209, 22, 0.12);

            --card-bg: #ffffff;
            --border-color: #cbd5e1;

            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth:
                all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* ==========================================================================
           2. Dark Mode
           ========================================================================== */

        .dark {
            --card-bg: #1e293b;
            --border-color: #334155;

            --text-primary: #f8fafc;
            --text-muted: #94a3b8;

            --dswd-blue-light: rgba(30, 64, 175, 0.2);
            --dswd-blue-border: rgba(30, 64, 175, 0.35);

            --dswd-red-light: rgba(220, 38, 38, 0.2);
            --dswd-red-border: rgba(220, 38, 38, 0.35);

            --dswd-yellow-light: rgba(252, 209, 22, 0.15);
        }


        /* ==========================================================================
           3. Main Layout
           ========================================================================== */

        .queue-report {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .queue-report__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }


        /* ==========================================================================
           4. Header Banner
           ========================================================================== */

        .queue-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .queue-banner__content {
            background:
                linear-gradient(
                    135deg,
                    var(--dswd-blue) 0%,
                    #1e40af 50%,
                    var(--dswd-red) 100%
                );
            padding: 24px;
            color: var(--text-white);
            position: relative;
        }

        .queue-banner__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .queue-banner__badge {
            color: var(--dswd-yellow);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .queue-banner__title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0 0 8px 0;
        }

        .queue-banner__description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            max-width: 650px;
            line-height: 1.6;
            margin: 0;
        }

        .queue-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .queue-banner__ribbon-stripe {
            height: 100%;
            width: 33.333%;
        }

        .queue-banner__ribbon-stripe--blue {
            background-color: var(--dswd-blue);
        }

        .queue-banner__ribbon-stripe--yellow {
            background-color: var(--dswd-yellow);
        }

        .queue-banner__ribbon-stripe--red {
            background-color: var(--dswd-red);
        }


        /* ==========================================================================
           5. Filter Card
           ========================================================================== */

        .queue-filter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .queue-filter-form {
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 12px;
        }

        .queue-filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .queue-filter-label {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .dark .queue-filter-label {
            color: #94a3b8;
        }

        .queue-filter-input {
            border: 1.5px solid #cbd5e1;
            border-radius: 8px;
            padding: 9px 12px;
            font-size: 14px;
            font-weight: 600;
            background-color: var(--card-bg);
            color: var(--text-primary);
            outline: none;
            transition: var(--transition-smooth);
        }

        .queue-filter-input:focus {
            border-color: var(--dswd-blue);
            box-shadow:
                0 0 0 3px rgba(0, 56, 168, 0.12);
        }


        /* ==========================================================================
           6. Buttons
           ========================================================================== */

        .queue-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            border: none;
            border-radius: 8px;
            padding: 10px 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .queue-btn--blue {
            background-color: var(--dswd-blue);
            color: white;
        }

        .queue-btn--blue:hover {
            background-color: var(--dswd-blue-hover);
            transform: translateY(-1px);
        }

        .queue-btn--red {
            background-color: var(--dswd-red);
            color: white;
        }

        .queue-btn--red:hover {
            background-color: var(--dswd-red-hover);
            transform: translateY(-1px);
        }


        /* ==========================================================================
           7. Summary Stats
           ========================================================================== */

        .queue-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .queue-stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
            border: none;
            border-bottom-width: 4px;
            transition: var(--transition-smooth);
        }

        .queue-stat-card:hover {
            transform: translateY(-2px);
            box-shadow:
                0 10px 25px -5px rgba(0, 56, 168, 0.1),
                0 0 1px rgba(0, 56, 168, 0.05);
        }

        .queue-stat-card--blue {
            border-bottom-color: var(--dswd-blue);
        }

        .queue-stat-card--yellow {
            border-bottom-color: var(--dswd-yellow);
        }

        .queue-stat-card--red {
            border-bottom-color: var(--dswd-red);
        }


        /* ==========================================================================
           8. Summary Content
           ========================================================================== */

        .queue-stat-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .queue-stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .queue-stat-value {
            font-size: 30px;
            font-weight: 950;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .queue-stat-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            align-self: flex-start;
        }

        .queue-stat-badge--blue {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .queue-stat-badge--yellow {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
        }

        .queue-stat-badge--red {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }


        /* ==========================================================================
           9. Summary Icon
           ========================================================================== */

        .queue-stat-icon {
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .queue-stat-icon--blue {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .queue-stat-icon--yellow {
            color: #b45309;
            background-color: var(--dswd-yellow-light);
        }

        .queue-stat-icon--red {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }


        /* ==========================================================================
           10. Breakdown
           ========================================================================== */

        .queue-breakdown {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-top: 2px;
            max-height: 72px;
            overflow-y: auto;
        }

        .queue-breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 11px;
            line-height: 1.4;
        }

        .queue-breakdown-name {
            color: var(--text-muted);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .queue-breakdown-count {
            color: var(--text-primary);
            font-weight: 800;
            flex-shrink: 0;
        }


        /* ==========================================================================
           11. Detailed Queue Card
           ========================================================================== */

        .queue-performance-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .queue-performance-card__header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .dark .queue-performance-card__header {
            border-bottom-color: #334155;
        }

        .queue-performance-card__title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
        }

        .queue-performance-card__subtitle {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .queue-performance-card__date {
            color: var(--dswd-blue);
            font-weight: 800;
        }


        /* ==========================================================================
           12. Table
           ========================================================================== */

        .queue-table-wrapper {
            overflow-x: auto;
        }

        .queue-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .queue-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 20px;
            border-bottom: 1px solid #e2e8f0;
            white-space: nowrap;
        }

        .dark .queue-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .queue-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }

        .dark .queue-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .queue-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .queue-table tbody tr:hover {
            background-color: rgba(0, 56, 168, 0.025);
        }


        /* ==========================================================================
           13. Table Data Styling
           ========================================================================== */

        .queue-number {
            color: var(--dswd-blue);
            font-family:
                ui-monospace,
                SFMono-Regular,
                Menlo,
                Monaco,
                Consolas,
                "Liberation Mono",
                "Courier New",
                monospace;
            font-size: 13px;
            font-weight: 800;
            white-space: nowrap;
        }

        .queue-client-name {
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            color: #334155;
        }

        .dark .queue-client-name {
            color: #e2e8f0;
        }

        .queue-priority {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .queue-priority--yes {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
            border: 1px solid rgba(252, 209, 22, 0.35);
        }

        .queue-priority--no {
            color: #64748b;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .dark .queue-priority--no {
            color: #94a3b8;
            background-color: #1e293b;
            border-color: #334155;
        }


        /* ==========================================================================
           14. Queue Status
           ========================================================================== */

        .queue-status {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .queue-status--serving {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border: 1px solid var(--dswd-blue-border);
        }

        .queue-status--waiting {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
            border: 1px solid rgba(252, 209, 22, 0.35);
        }

        .queue-status--completed {
            color: #047857;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .queue-status--cancelled {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border: 1px solid var(--dswd-red-border);
        }

        .queue-status--abandoned {
            color: #64748b;
            background-color: #f1f5f9;
            border: 1px solid #cbd5e1;
        }


        /* ==========================================================================
           15. Other Table Data
           ========================================================================== */

        .queue-duration {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .queue-step {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .queue-date {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .queue-muted {
            color: #94a3b8;
            font-size: 12px;
            font-style: italic;
        }


        /* ==========================================================================
           16. Empty State
           ========================================================================== */

        .queue-empty {
            padding: 48px 24px !important;
            text-align: center;
            color: #94a3b8 !important;
            font-weight: 600 !important;
        }


        /* ==========================================================================
           17. Pagination
           ========================================================================== */

        .queue-pagination {
            padding: 20px 24px;
            border-top: 1px solid #f1f5f9;
        }

        .dark .queue-pagination {
            border-top-color: #334155;
        }


        /* ==========================================================================
           18. Responsive
           ========================================================================== */

        @media (max-width: 1024px) {

            .queue-summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 640px) {

            .queue-report__container {
                padding: 0 16px;
            }

            .queue-banner__title {
                font-size: 24px;
            }

            .queue-filter-form {
                flex-direction: column;
                align-items: stretch;
            }

            .queue-btn {
                width: 100%;
            }

            .queue-summary-grid {
                grid-template-columns: 1fr;
            }

            .queue-performance-card__header {
                align-items: flex-start;
                flex-direction: column;
            }

            .queue-table th,
            .queue-table td {
                padding: 12px 16px;
            }
        }

    </style>


    <div class="queue-report">
        <div class="queue-report__container">
            <div class="queue-banner">
                <div class="queue-banner__content">
                    <div class="queue-banner__bg-icon">
                        <svg
                            width="240"
                            height="240"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M3 3h18v18H3V3zm3
                                4h12v2H6V7zm0 4h12v2H6v-2zm0
                                4h8v2H6v-2z"
                            />
                        </svg>
                    </div>
                    <p class="queue-banner__badge">
                        DSWD Operations Control Hub
                    </p>
                    <h1 class="queue-banner__title">
                        Queue Performance Report
                    </h1>
                    <p class="queue-banner__description">
                        Monitor queue activity, service performance,
                        processing duration, and queue status across
                        the selected reporting period.
                    </p>
                </div>
                <div class="queue-banner__ribbon">
                    <div
                        class="queue-banner__ribbon-stripe
                               queue-banner__ribbon-stripe--blue">
                    </div>
                    <div
                        class="queue-banner__ribbon-stripe
                               queue-banner__ribbon-stripe--yellow">
                    </div>
                    <div
                        class="queue-banner__ribbon-stripe
                               queue-banner__ribbon-stripe--red">
                    </div>
                </div>
            </div>
            <div class="queue-filter-card">
                <form
                    method="GET"
                    action="{{ route('admin.queue-performance') }}"
                    class="queue-filter-form"
                >
                    <div class="queue-filter-group">
                        <label
                            for="date_from"
                            class="queue-filter-label"
                        >
                            {{ __('From') }}
                        </label>
                        <input
                            type="date"
                            id="date_from"
                            name="date_from"
                            class="queue-filter-input"
                            value="{{ $dateFrom }}"
                        />
                    </div>
                    <div class="queue-filter-group">
                        <label
                            for="date_to"
                            class="queue-filter-label"
                        >
                            {{ __('To') }}
                        </label>
                        <input
                            type="date"
                            id="date_to"
                            name="date_to"
                            class="queue-filter-input"
                            value="{{ $dateTo }}"
                        />
                    </div>
                    <button
                        type="submit"
                        class="queue-btn queue-btn--blue"
                    >
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 4h18M3 10h18M3 16h18M3 22h18"
                            />
                        </svg>

                        {{ __('View Report') }}

                    </button>
                    <a
                        href="{{ route('admin.queue-performance.export', [
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="queue-btn queue-btn--red"
                    >
                        <svg
                            width="16"
                            height="16"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M12 10v6m0 0l-3-3m3 3l3-3
                                M5 20h14a2 2 0 002-2V6
                                a2 2 0 00-2-2H5a2 2 0
                                01-2 2v12a2 2 0 002 2z"
                            />
                        </svg>
                        {{ __('Download Excel') }}
                    </a>
                </form>
            </div>
            <div class="queue-summary-grid">
                <div class="queue-stat-card queue-stat-card--blue">
                    <div class="queue-stat-content">
                        <span class="queue-stat-label">
                            {{ __('Total Queues') }}
                        </span>
                        <div class="queue-stat-value">
                            {{ $totalQueues }}
                        </div>
                        <span
                            class="queue-stat-badge
                                   queue-stat-badge--blue"
                        >
                            {{ __('Queues Issued') }}
                        </span>
                    </div>
                    <div
                        class="queue-stat-icon
                               queue-stat-icon--blue"
                    >
                        <svg
                            width="24"
                            height="24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <path d="M4 4h16v16H4z" />
                            <path d="M8 8h8M8 12h8M8 16h5" />
                        </svg>
                    </div>
                </div>
                <div class="queue-stat-card queue-stat-card--yellow">
                    <div class="queue-stat-content">
                        <span class="queue-stat-label">
                            {{ __('Served by Status') }}
                        </span>
                        <div class="queue-breakdown">
                            @forelse($servedCount as $status => $count)
                                <div class="queue-breakdown-row">
                                    <span class="queue-breakdown-name">
                                        {{ $status }}
                                    </span>
                                    <span class="queue-breakdown-count">
                                        {{ $count }}
                                    </span>
                                </div>
                            @empty
                                <span class="text-xs text-gray-400">
                                    {{ __('No data') }}
                                </span>
                            @endforelse
                        </div>
                        <span
                            class="queue-stat-badge
                                   queue-stat-badge--yellow"
                        >
                            {{ __('By Queue Status') }}
                        </span>
                    </div>
                    <div
                        class="queue-stat-icon
                               queue-stat-icon--yellow"
                    >
                        <svg
                            width="24"
                            height="24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <path d="M4 12h16" />
                            <path d="M12 4v16" />
                            <circle cx="12" cy="12" r="9" />
                        </svg>
                    </div>
                </div>
                <div class="queue-stat-card queue-stat-card--red">
                    <div class="queue-stat-content">
                        <span class="queue-stat-label">
                            {{ __('Avg Time per Step') }}
                        </span>
                        <div class="queue-breakdown">
                            @forelse($avgTimePerStep as $step => $minutes)
                                <div class="queue-breakdown-row">
                                    <span class="queue-breakdown-name">
                                        {{ $step }}
                                    </span>
                                    <span class="queue-breakdown-count">
                                        {{ round($minutes, 1) }} min
                                    </span>
                                </div>
                            @empty
                                <span class="text-xs text-gray-400">
                                    {{ __('No data') }}
                                </span>
                            @endforelse
                        </div>
                        <span
                            class="queue-stat-badge
                                   queue-stat-badge--red"
                        >
                            {{ __('Processing Time') }}
                        </span>
                    </div>
                    <div
                        class="queue-stat-icon
                               queue-stat-icon--red"
                    >
                        <svg
                            width="24"
                            height="24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <circle cx="12" cy="12" r="9" />
                            <path d="M12 7v5l3 2" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="queue-performance-card">
                <div class="queue-performance-card__header">
                    <div>
                        <h2 class="queue-performance-card__title">
                            {{ __('Queue Performance Details') }}
                        </h2>
                        <p class="queue-performance-card__subtitle">
                            {{ __('Showing queues from:') }}
                            <span class="queue-performance-card__date">
                                {{
                                    \Carbon\Carbon::parse($dateFrom)
                                        ->format('M d, Y')
                                }}
                                —
                                {{
                                    \Carbon\Carbon::parse($dateTo)
                                        ->format('M d, Y')
                                }}
                            </span>
                        </p>
                    </div>
                </div>
                {{-- Table --}}
                <div class="queue-table-wrapper">
                    <table class="queue-table">
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
                            @forelse($queues as $queue)
                                <tr>
                                    <td>
                                        <span class="queue-number">
                                            {{ $queue->queue_number }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="queue-client-name">
                                            {{ $queue->client->first_name }}
                                            {{ $queue->client->last_name }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="queue-category">
                                            {{ $queue->client->client_category }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($queue->priority)
                                            <span
                                                class="queue-priority
                                                       queue-priority--yes"
                                            >
                                                Yes
                                            </span>
                                        @else
                                            <span
                                                class="queue-priority
                                                       queue-priority--no"
                                            >
                                                No
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match(
                                                $queue->queue_status
                                            ) {
                                                'Serving'
                                                    => 'queue-status--serving',

                                                'Waiting'
                                                    => 'queue-status--waiting',

                                                'Completed'
                                                    => 'queue-status--completed',

                                                'Cancelled'
                                                    => 'queue-status--cancelled',

                                                'Abandoned'
                                                    => 'queue-status--abandoned',

                                                default
                                                    => 'queue-status--abandoned',
                                            };
                                        @endphp
                                        <span
                                            class="queue-status
                                                   {{ $statusClass }}"
                                        >
                                            {{ $queue->queue_status }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($queue->queue_status === 'Abandoned')
                                            <span class="queue-muted">
                                                {{ __('Abandoned') }}
                                            </span>
                                        @elseif(
                                            in_array(
                                                $queue->queue_status,
                                                ['Completed', 'Cancelled']
                                            )
                                            &&
                                            $queue->latestProcessing?->end_time
                                        )
                                            @php
                                                $duration =
                                                    \Carbon\Carbon::parse(
                                                        $queue->date_issued
                                                    )->diffForHumans(
                                                        $queue->latestProcessing
                                                            ->end_time,
                                                        true
                                                    );
                                            @endphp
                                            <span class="queue-duration">
                                                {{ $duration }}
                                            </span>
                                        @else
                                            <span class="queue-muted">
                                                {{ __('In Progress') }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="queue-step">
                                            {{
                                                $queue
                                                    ->latestProcessing
                                                    ->current_step
                                                    ?? '—'
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="queue-date">
                                            {{
                                                \Carbon\Carbon::parse(
                                                    $queue->date_issued
                                                )->format(
                                                    'M d, Y h:i A'
                                                )
                                            }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="queue-empty">
                                        {{ __('No queues for this date range.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="queue-pagination">
                    {{ $queues->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>