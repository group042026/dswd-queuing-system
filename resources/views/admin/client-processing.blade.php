<x-admin-layout>

    <style>

        /* ==========================================================================
           1. Theme Variables
           ========================================================================== */

        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;

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
        }


        /* ==========================================================================
           3. Main Layout
           ========================================================================== */

        .processing-report {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .processing-report__container {
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

        .processing-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .processing-banner__content {
            background:
                linear-gradient(
                    135deg,
                    #0038a8 0%,
                    #1e40af 50%,
                    #ce1126 100%
                );

            padding: 24px;
            color: var(--text-white);
        }

        .processing-banner__badge {
            color: #fcd116;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;

            margin: 0 0 6px 0;
        }

        .processing-banner__title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.025em;

            margin: 0 0 8px 0;
        }

        .processing-banner__description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            line-height: 1.6;

            max-width: 650px;
            margin: 0;
        }

        .processing-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .processing-banner__ribbon-stripe {
            height: 100%;
            width: 33.333%;
        }

        .processing-banner__ribbon-stripe--blue {
            background-color: #0038a8;
        }

        .processing-banner__ribbon-stripe--yellow {
            background-color: #fcd116;
        }

        .processing-banner__ribbon-stripe--red {
            background-color: #ce1126;
        }


        /* ==========================================================================
           5. Current Snapshot
           ========================================================================== */

        .processing-snapshot {
            background-color: var(--card-bg);
            border-radius: 12px;

            padding: 24px;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .processing-snapshot__title {
            font-size: 14px;
            font-weight: 700;

            color: var(--text-muted);

            text-transform: uppercase;
            letter-spacing: 0.05em;

            margin: 0 0 20px 0;
        }

        .processing-snapshot-grid {
            display: grid;

            grid-template-columns: repeat(6, 1fr);

            gap: 24px;
        }

        .processing-snapshot-item {
            min-width: 0;
        }

        .processing-snapshot-item__label {
            font-size: 14px;
            font-weight: 500;

            color: var(--text-muted);

            margin-bottom: 4px;
        }

        .processing-snapshot-item__value {
            font-size: 30px;
            font-weight: 800;

            line-height: 1.2;

            color: var(--text-primary);
        }


        /* ==========================================================================
           6. Filter Card
           ========================================================================== */

        .processing-filter-card {
            background-color: var(--card-bg);

            border-radius: 12px;

            padding: 20px 24px;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .processing-filter-form {
            display: flex;

            align-items: flex-end;
            flex-wrap: wrap;

            gap: 12px;
        }

        .processing-filter-group {
            display: flex;
            flex-direction: column;

            gap: 6px;
        }

        .processing-filter-label {
            color: #475569;

            font-size: 12px;
            font-weight: 700;
        }

        .dark .processing-filter-label {
            color: #94a3b8;
        }

        .processing-filter-input {
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

        .processing-filter-input:focus {
            border-color: var(--dswd-blue);

            box-shadow:
                0 0 0 3px rgba(0, 56, 168, 0.12);
        }


        /* ==========================================================================
           7. Buttons
           ========================================================================== */

        .processing-btn {
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

        .processing-btn--blue {
            background-color: var(--dswd-blue);
            color: white;
        }

        .processing-btn--blue:hover {
            background-color: var(--dswd-blue-hover);

            transform: translateY(-1px);
        }

        .processing-btn--red {
            background-color: #ce1126;
            color: white;
        }

        .processing-btn--red:hover {
            background-color: #b00e1f;

            transform: translateY(-1px);
        }


        /* ==========================================================================
           8. Historical Processing Card
           ========================================================================== */

        .processing-history-card {
            background-color: var(--card-bg);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .processing-history-card__header {
            padding: 20px 24px;

            border-bottom: 1px solid #f1f5f9;

            display: flex;

            align-items: center;
            justify-content: space-between;

            gap: 12px;

            flex-wrap: wrap;
        }

        .dark .processing-history-card__header {
            border-bottom-color: #334155;
        }

        .processing-history-card__title {
            font-size: 16px;
            font-weight: 800;

            color: var(--text-primary);

            margin: 0;
        }

        .processing-history-card__subtitle {
            margin: 4px 0 0 0;

            font-size: 12px;

            color: var(--text-muted);
        }

        .processing-history-card__date {
            color: var(--dswd-blue);

            font-weight: 800;
        }


        /* ==========================================================================
           9. Table
           ========================================================================== */

        .processing-table-wrapper {
            overflow-x: auto;
        }

        .processing-table {
            width: 100%;

            border-collapse: collapse;

            text-align: left;

            font-size: 14px;
        }

        .processing-table th {
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

        .dark .processing-table th {
            background-color: #1e293b;

            border-bottom-color: #334155;
        }

        .processing-table td {
            padding: 15px 20px;

            border-bottom: 1px solid #f1f5f9;

            color: #334155;

            font-weight: 600;

            vertical-align: middle;
        }

        .dark .processing-table td {
            border-bottom-color: #334155;

            color: #cbd5e1;
        }

        .processing-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .processing-table tbody tr:hover {
            background-color: rgba(0, 56, 168, 0.025);
        }


        /* ==========================================================================
           10. Table Data
           ========================================================================== */

        .processing-queue-number {
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

            color: #334155;
        }

        .dark .processing-queue-number {
            color: #cbd5e1;
        }

        .processing-client-name {
            font-size: 13px;
            font-weight: 700;

            white-space: nowrap;

            color: #334155;
        }

        .dark .processing-client-name {
            color: #e2e8f0;
        }

        .processing-step {
            font-size: 13px;

            color: #475569;

            font-weight: 600;
        }

        .dark .processing-step {
            color: #94a3b8;
        }

        .processing-user {
            font-size: 13px;

            color: #475569;

            font-weight: 600;
        }

        .dark .processing-user {
            color: #94a3b8;
        }

        .processing-date {
            font-size: 12px;

            color: var(--text-muted);

            white-space: nowrap;
        }


        /* ==========================================================================
           11. Status Badge
           ========================================================================== */

        .processing-status {
            display: inline-block;

            padding: 4px 10px;

            border-radius: 9999px;

            font-size: 11px;
            font-weight: 700;

            white-space: nowrap;
        }

        .processing-status--processing {
            color: #1d4ed8;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .processing-status--waiting {
            color: #92400e;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
        }

        .processing-status--completed {
            color: #047857;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .processing-status--cancelled {
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }


        /* ==========================================================================
           12. Empty State
           ========================================================================== */

        .processing-empty {
            padding: 48px 24px !important;

            text-align: center;

            color: #94a3b8 !important;

            font-weight: 600 !important;
        }


        /* ==========================================================================
           13. Pagination
           ========================================================================== */

        .processing-pagination {
            padding: 20px 24px;

            border-top: 1px solid #f1f5f9;
        }

        .dark .processing-pagination {
            border-top-color: #334155;
        }


        /* ==========================================================================
           14. Responsive
           ========================================================================== */

        @media (max-width: 1024px) {

            .processing-snapshot-grid {
                grid-template-columns: repeat(3, 1fr);
            }

        }


        @media (max-width: 768px) {

            .processing-snapshot-grid {
                grid-template-columns: repeat(2, 1fr);

                gap: 20px;
            }

        }


        @media (max-width: 640px) {

            .processing-report__container {
                padding: 0 16px;
            }

            .processing-banner__title {
                font-size: 24px;
            }

            .processing-filter-form {
                flex-direction: column;

                align-items: stretch;
            }

            .processing-btn {
                width: 100%;
            }

            .processing-snapshot-grid {
                grid-template-columns: 1fr;

                gap: 18px;
            }

            .processing-history-card__header {
                align-items: flex-start;

                flex-direction: column;
            }

            .processing-table th,
            .processing-table td {
                padding: 12px 16px;
            }

        }

    </style>

    <div class="processing-report">
        <div class="processing-report__container">
            <div class="processing-banner">
                <div class="processing-banner__content">
                    <p class="processing-banner__badge">
                        DSWD Operations Control Hub
                    </p>
                    <h1 class="processing-banner__title">
                        Client Processing Report
                    </h1>
                    <p class="processing-banner__description">
                        Monitor active client processing and review
                        historical processing records.
                    </p>
                </div>
                <div class="processing-banner__ribbon">
                    <div
                        class="processing-banner__ribbon-stripe
                               processing-banner__ribbon-stripe--blue">
                    </div>
                    <div
                        class="processing-banner__ribbon-stripe
                               processing-banner__ribbon-stripe--yellow">
                    </div>
                    <div
                        class="processing-banner__ribbon-stripe
                               processing-banner__ribbon-stripe--red">
                    </div>
                </div>
            </div>
            <div class="processing-snapshot">
                <h2 class="processing-snapshot__title">
                    Current Snapshot (Live)
                </h2>
                <div class="processing-snapshot-grid">
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Total Active
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="totalStuck">
                            {{ $totalStuck }}
                        </div>
                    </div>
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Validation
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="Validation">
                            {{ $stuckPerStage['Validation'] ?? 0 }}
                        </div>
                    </div>
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Assessment
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="Assessment">
                            {{ $stuckPerStage['Assessment'] ?? 0 }}
                        </div>
                    </div>
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Review
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="Review">
                            {{ $stuckPerStage['Review'] ?? 0 }}
                        </div>
                    </div>
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Releasing
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="Releasing">
                            {{ $stuckPerStage['Releasing'] ?? 0 }}
                        </div>
                    </div>
                    <div class="processing-snapshot-item">
                        <div class="processing-snapshot-item__label">
                            Completed Today
                        </div>
                        <div class="processing-snapshot-item__value" data-snapshot="completedToday">
                            {{ $completedToday }}
                        </div>
                    </div>

                </div>
            </div>
            <div class="processing-filter-card">
                <form
                    method="GET"
                    action="{{ route('admin.client-processing') }}"
                    class="processing-filter-form"
                >
                    <div class="processing-filter-group">
                        <label
                            for="date_from"
                            class="processing-filter-label"
                        >
                            From
                        </label>
                        <input
                            id="date_from"
                            name="date_from"
                            type="date"
                            class="processing-filter-input"
                            value="{{ $dateFrom }}"
                        />
                    </div>
                    <div class="processing-filter-group">
                        <label
                            for="date_to"
                            class="processing-filter-label"
                        >
                            To
                        </label>
                        <input
                            id="date_to"
                            name="date_to"
                            type="date"
                            class="processing-filter-input"
                            value="{{ $dateTo }}"
                        />
                    </div>
                    <button
                        type="submit"
                        class="processing-btn processing-btn--blue"
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
                        href="{{ route('admin.client-processing.export', [
                            'date_from' => $dateFrom,
                            'date_to' => $dateTo
                        ]) }}"
                        class="processing-btn processing-btn--red"
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
            <div class="processing-history-card">
                <div class="processing-history-card__header">
                    <div>
                        <h2 class="processing-history-card__title">
                            Processing History
                        </h2>
                        <p class="processing-history-card__subtitle">
                            Showing processing history from:
                            <span class="processing-history-card__date">
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
                <div class="processing-table-wrapper">
                    <table class="processing-table">
                        <thead>
                            <tr>
                                <th>
                                    Queue Number
                                </th>
                                <th>
                                    Client Name
                                </th>
                                <th>
                                    Step
                                </th>
                                <th>
                                    Status
                                </th>
                                <th>
                                    Handled By
                                </th>
                                <th>
                                    Start Time
                                </th>
                                <th>
                                    End Time
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($processingHistory as $processing)
                                <tr>
                                    <td>
                                        <span class="processing-queue-number">
                                            {{
                                                $processing->queue
                                                    ->queue_number
                                                    ?? '—'
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="processing-client-name">
                                            {{
                                                $processing->client
                                                    ->first_name
                                            }}
                                            {{
                                                $processing->client
                                                    ->last_name
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="processing-step">
                                            {{ $processing->current_step }}
                                        </span>
                                    </td>
                                    <td>
                                        @php
                                            $statusClass = match(
                                                $processing->current_status
                                            ) {
                                                'Processing'
                                                    => 'processing-status--processing',
                                                'Waiting'
                                                    => 'processing-status--waiting',
                                                'Completed'
                                                    => 'processing-status--completed',
                                                'Cancelled'
                                                    => 'processing-status--cancelled',
                                                default
                                                    => 'processing-status--waiting',
                                            };
                                        @endphp
                                        <span
                                            class="processing-status {{ $statusClass }}"
                                        >
                                            {{ $processing->current_status }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="processing-user">
                                            {{
                                                $processing->user
                                                    ? "{$processing->user->first_name} {$processing->user->last_name}"
                                                    : '—'
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="processing-date">
                                            {{
                                                $processing->start_time
                                                    ->format('M d, Y h:i A')
                                            }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="processing-date">
                                            {{
                                                $processing->end_time
                                                    ? $processing->end_time
                                                        ->format('M d, Y h:i A')
                                                    : '—'
                                            }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td
                                        colspan="7"
                                        class="processing-empty"
                                    >
                                        {{ __('No processing records for this date range.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="processing-pagination">
                    {{ $processingHistory->links() }}
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        console.log('Client processing realtime script loaded.');
        window.Echo.channel('admin-dashboard')
            .listen('.dashboard.updated', () => {
                const params = new URLSearchParams({
                    date_from: document.getElementById('date_from').value,
                    date_to: document.getElementById('date_to').value,
                });

                fetch(`{{ route('admin.client-processing.data') }}?${params}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`HTTP error: ${response.status}`);
                        }

                        return response.json();
                    })
                    .then(data => {
                        const updateSnapshot = (key, value) => {
                            const element = document.querySelector(
                                `[data-snapshot="${key}"]`
                            );

                            if (element) {
                                element.textContent = value;
                            }
                        };

                        updateSnapshot('totalStuck', data.totalStuck ?? 0);

                        ['Validation', 'Assessment', 'Review', 'Releasing']
                            .forEach(stage => {
                                updateSnapshot(
                                    stage,
                                    data.stuckPerStage?.[stage] ?? 0
                                );
                            });

                        updateSnapshot(
                            'completedToday',
                            data.completedToday ?? 0
                        );
                    })
                    .catch(error => {
                        console.error(
                            'Failed to update processing snapshot:',
                            error
                        );
                    });
            });
    });
</script>
@endpush
</x-admin-layout>