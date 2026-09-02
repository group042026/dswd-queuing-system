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

            --emerald-green: #047857;
            --emerald-light: #ecfdf5;
            --emerald-border: #a7f3d0;

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

            --emerald-green: #34d399;
            --emerald-light: rgba(52, 211, 153, 0.1);
            --emerald-border: rgba(52, 211, 153, 0.25);
        }


        /* ==========================================================================
           3. Main Layout
           ========================================================================== */

        .monthly-report {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .monthly-report__container {
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

        .monthly-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .monthly-banner__content {
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

        .monthly-banner__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .monthly-banner__badge {
            color: var(--dswd-yellow);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .monthly-banner__title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0 0 8px 0;
        }

        .monthly-banner__description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            max-width: 650px;
            line-height: 1.6;
            margin: 0;
        }

        .monthly-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .monthly-banner__ribbon-stripe {
            height: 100%;
            width: 33.333%;
        }

        .monthly-banner__ribbon-stripe--blue {
            background-color: var(--dswd-blue);
        }

        .monthly-banner__ribbon-stripe--yellow {
            background-color: var(--dswd-yellow);
        }

        .monthly-banner__ribbon-stripe--red {
            background-color: var(--dswd-red);
        }

        /* ==========================================================================
           5. Filter Card
           ========================================================================== */

        .monthly-filter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px 24px;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .monthly-filter-form {
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 12px;
        }

        .monthly-filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .monthly-filter-label {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .dark .monthly-filter-label {
            color: #94a3b8;
        }

        .monthly-filter-input {
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

        .monthly-filter-input:focus {
            border-color: var(--dswd-blue);
            box-shadow:
                0 0 0 3px rgba(0, 56, 168, 0.12);
        }

        /* ==========================================================================
           6. Buttons
           ========================================================================== */

        .monthly-btn {
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

        .monthly-btn--blue {
            background-color: var(--dswd-blue);
            color: white;
        }

        .monthly-btn--blue:hover {
            background-color: var(--dswd-blue-hover);
            transform: translateY(-1px);
        }

        .monthly-btn--red {
            background-color: var(--dswd-red);
            color: white;
        }

        .monthly-btn--red:hover {
            background-color: var(--dswd-red-hover);
            transform: translateY(-1px);
        }

        /* ==========================================================================
        Summary Stats - Same Design as Admin Dashboard
        ========================================================================== */

        .monthly-summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .monthly-stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: none;
            border-bottom-width: 4px;
            transition: var(--transition-smooth);
            /* min-height: 150px; */
        }

        .monthly-stat-card:hover {
            transform: translateY(-2px);
            box-shadow:
                0 10px 25px -5px rgba(0, 56, 168, 0.1),
                0 0 1px rgba(0, 56, 168, 0.05);
        }

        .monthly-stat-card--blue {
            border-bottom-color: var(--dswd-blue);
        }

        .monthly-stat-card--yellow {
            border-bottom-color: var(--dswd-yellow);
        }

        .monthly-stat-card--red {
            border-bottom-color: var(--dswd-red);
        }

        /* Content */
        .monthly-stat-content {
            display: flex;
            flex-direction: column;
            gap: 4px;
            min-width: 0;
        }

        .monthly-stat-label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .monthly-stat-value {
            font-size: 30px;
            font-weight: 950;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .monthly-stat-badge {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            align-self: flex-start;
        }

        .monthly-stat-badge--blue {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .monthly-stat-badge--yellow {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
        }

        .monthly-stat-badge--red {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }

        /* Icon */
        .monthly-stat-icon {
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .monthly-stat-icon--blue {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .monthly-stat-icon--yellow {
            color: #b45309;
            background-color: var(--dswd-yellow-light);
        }

        .monthly-stat-icon--red {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }

        /* Breakdown inside cards */

        .monthly-breakdown {
            display: flex;
            flex-direction: column;
            gap: 3px;
            margin-top: 2px;
            max-height: 72px;
            overflow-y: auto;
        }

        .monthly-breakdown-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-size: 11px;
            line-height: 1.4;
        }

        .monthly-breakdown-name {
            color: var(--text-muted);
            font-weight: 600;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 150px;
        }

        .monthly-breakdown-count {
            color: var(--text-primary);
            font-weight: 800;
            flex-shrink: 0;
        }

        /* ==========================================================================
           11. Detailed Transactions Card
           ========================================================================== */

        .monthly-transactions-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            overflow: hidden;
            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .monthly-transactions-card__header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
        }

        .dark .monthly-transactions-card__header {
            border-bottom-color: #334155;
        }

        .monthly-transactions-card__title {
            font-size: 16px;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
        }

        .monthly-transactions-card__subtitle {
            margin: 4px 0 0 0;
            font-size: 12px;
            color: var(--text-muted);
        }

        .monthly-transactions-card__date {
            color: var(--dswd-blue);
            font-weight: 800;
        }

        /* ==========================================================================
           12. Table
           ========================================================================== */

        .monthly-table-wrapper {
            overflow-x: auto;
        }

        .monthly-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .monthly-table th {
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

        .dark .monthly-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .monthly-table td {
            padding: 15px 20px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
            white-space: nowrap;
        }

        .dark .monthly-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .monthly-table tbody tr {
            transition: background-color 0.2s ease;
        }

        .monthly-table tbody tr:hover {
            background-color: rgba(0, 56, 168, 0.025);
        }

        /* ==========================================================================
           13. Table Data Styling
           ========================================================================== */

        .monthly-control-number {
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

        .monthly-queue-number {
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

        .dark .monthly-queue-number {
            color: #cbd5e1;
        }

        .monthly-client-name {
            font-size: 13px;
            font-weight: 700;
            white-space: nowrap;
            color: #334155;
        }

        .dark .monthly-client-name {
            color: #e2e8f0;
        }

        .monthly-program {
            max-width: 220px;
            font-size: 13px;
            color: #475569;

            font-weight: 600;
        }

        .dark .monthly-program {
            color: #94a3b8;
        }

        .monthly-date {
            font-size: 12px;
            color: var(--text-muted);
            white-space: nowrap;
        }


        /* ==========================================================================
           14. Category Badge
           ========================================================================== */

        .monthly-category {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 9999px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        /* Senior */
        .monthly-category--senior {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border: 1px solid var(--dswd-blue-border);
        }

        /* Family Heads and Other Needy Adult */
        .monthly-category--family-head {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border: 1px solid var(--dswd-red-border);
        }

        /* Youth in Need and Other Needy Adult */
        .monthly-category--youth {
            color: #92400e;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
        }

        /* Youth in Need of Special Protection */
        .monthly-category--youth-protection {
            color: #166534;
            background-color: #f0fdf4;
            border: 1px solid #bbf7d0;
        }

        /* Men/Women in Specially Difficult Circumstances */
        .monthly-category--difficult-circumstances {
            color: #7c2d12;
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
        }

        /* Fallback */
        .monthly-category--regular {
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        /* ==========================================================================
           15. Empty State
           ========================================================================== */

        .monthly-empty {
            padding: 48px 24px !important;
            text-align: center;
            color: #94a3b8 !important;
            font-weight: 600 !important;
        }


        /* ==========================================================================
           16. Pagination
           ========================================================================== */

        .monthly-pagination {
            padding: 20px 24px;
            border-top: 1px solid #f1f5f9;
        }

        .dark .monthly-pagination {
            border-top-color: #334155;
        }


        /* ==========================================================================
           17. Responsive
           ========================================================================== */

        @media (max-width: 1024px) {

            .monthly-summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

        }


        @media (max-width: 640px) {
            .monthly-report__container {
                padding: 0 16px;
            }
            .monthly-banner__title {
                font-size: 24px;
            }
            .monthly-filter-form {
                flex-direction: column;

                align-items: stretch;
            }
            .monthly-btn {
                width: 100%;
            }
            .monthly-summary-grid {
                grid-template-columns: 1fr;
            }
            /* .monthly-summary-grid {
                display: grid;
                grid-template-columns: repeat(3, 1fr);
                gap: 24px;
            } */
            .monthly-transactions-card__header {
                align-items: flex-start;

                flex-direction: column;
            }
            .monthly-table th,
            .monthly-table td {
                padding: 12px 16px;
            }
        }

    </style>

    <div class="monthly-report">
        <div class="monthly-report__container">
            <div class="monthly-banner">
                <div class="monthly-banner__content">
                    <div class="monthly-banner__bg-icon">
                        <svg
                            width="240"
                            height="240"
                            fill="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                d="M19 3H5c-1.1 0-2 .9-2 2v14
                                c0 1.1.9 2 2 2h14c1.1 0 2-.9
                                2-2V5c0-1.1-.9-2-2-2zm-2
                                12h-3v3h-2v-3H9v-2h3v-3h2v3h3v2z"
                            />
                        </svg>
                    </div>
                    <p class="monthly-banner__badge">
                        DSWD Operations Control Hub
                    </p>

                    <h1 class="monthly-banner__title">
                        Monthly Transaction Report
                    </h1>

                    <p class="monthly-banner__description">
                        Review monthly transaction activity,
                        monitor program distribution, and export
                        consolidated transaction records.
                    </p>
                </div>
                <div class="monthly-banner__ribbon">
                    <div
                        class="monthly-banner__ribbon-stripe
                               monthly-banner__ribbon-stripe--blue">
                    </div>
                    <div
                        class="monthly-banner__ribbon-stripe
                               monthly-banner__ribbon-stripe--yellow">
                    </div>
                    <div
                        class="monthly-banner__ribbon-stripe
                               monthly-banner__ribbon-stripe--red">
                    </div>
                </div>
            </div>
            <div class="monthly-filter-card">
                <form
                    method="GET"
                    action="{{ route('admin.monthly-transaction') }}"
                    class="monthly-filter-form"
                >
                    <div class="monthly-filter-group">
                        <label
                            for="month"
                            class="monthly-filter-label"
                        >
                            {{ __('Select Report Month') }}
                        </label>
                        <input
                            type="month"
                            id="month"
                            name="month"
                            class="monthly-filter-input"
                            value="{{ $selectedMonth }}"
                        />
                    </div>
                    <button
                        type="submit"
                        class="monthly-btn monthly-btn--blue"
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
                    <a href="{{ route('admin.monthly-transaction.export', ['month' => $selectedMonth]) }}"class="monthly-btn monthly-btn--red">
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

            {{-- Summary cards --}}
            <div class="monthly-summary-grid">
                <div class="monthly-stat-card monthly-stat-card--blue">
                    <div class="monthly-stat-content">
                        <span class="monthly-stat-label">
                            {{ __('Total Transactions') }}
                        </span>
                        <div class="monthly-stat-value">
                            {{ $totalTransactions }}
                        </div>
                        <span class="monthly-stat-badge monthly-stat-badge--blue">
                            {{ __('Completed Transactions') }}
                        </span>
                    </div>
                    <div class="monthly-stat-icon monthly-stat-icon--blue">
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
                            <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                            <rect
                                x="9"
                                y="3"
                                width="6"
                                height="4"
                                rx="1"
                            />
                            <path d="M9 12h6M9 16h6" />
                        </svg>
                    </div>
                </div>
                <div class="monthly-stat-card monthly-stat-card--yellow">
                    <div class="monthly-stat-content">
                        <span class="monthly-stat-label">
                            {{ __('Per Program') }}
                        </span>
                        <div class="monthly-breakdown">
                            @forelse($perProgram as $program => $count)
                                <div class="monthly-breakdown-row">
                                    <span class="monthly-breakdown-name">
                                        {{ $program }}
                                    </span>
                                    <span class="monthly-breakdown-count">
                                        {{ $count }}
                                    </span>
                                </div>
                            @empty
                                <span class="text-xs text-gray-400">
                                    {{ __('No data') }}
                                </span>
                            @endforelse
                        </div>
                        <span class="monthly-stat-badge monthly-stat-badge--yellow">
                            {{ __('By Program') }}
                        </span>
                    </div>
                    <div class="monthly-stat-icon monthly-stat-icon--yellow">
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
                            <path d="M4 19.5A2.5 2.5 0 016.5 17H20" />
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 014 19.5v-15A2.5 2.5 0 016.5 2z" />
                            <path d="M8 7h8M8 11h8M8 15h5" />
                        </svg>
                    </div>
                </div>
                <div class="monthly-stat-card monthly-stat-card--red">
                    <div class="monthly-stat-content">
                        <span class="monthly-stat-label">
                            {{ __('Per Category') }}
                        </span>
                        <div class="monthly-breakdown">
                            @forelse($perCategory as $category => $count)
                                <div class="monthly-breakdown-row">
                                    <span class="monthly-breakdown-name">
                                        {{ $category }}
                                    </span>
                                    <span class="monthly-breakdown-count">
                                        {{ $count }}
                                    </span>
                                </div>
                            @empty
                                <span class="text-xs text-gray-400">
                                    {{ __('No data') }}
                                </span>
                            @endforelse
                        </div>
                        <span class="monthly-stat-badge monthly-stat-badge--red">
                            {{ __('By Category') }}
                        </span>
                    </div>
                    <div class="monthly-stat-icon monthly-stat-icon--red">
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
                            <circle cx="12" cy="8" r="3" />
                            <path d="M6 20c0-3.3 2.7-6 6-6s6 2.7 6 6" />
                            <path d="M4 20h16" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="monthly-transactions-card">
                <div class="monthly-transactions-card__header">
                    <div>
                        <h2 class="monthly-transactions-card__title">
                            {{ __('Transaction Details') }}
                        </h2>
                        <p class="monthly-transactions-card__subtitle">
                            {{ __('Showing transactions for:') }}
                            <span class="monthly-transactions-card__date">
                                {{
                                    \Carbon\Carbon::parse(
                                        $selectedMonth . '-01'
                                    )->format('F Y')
                                }}
                            </span>
                        </p>
                    </div>
                </div>
                <div class="monthly-table-wrapper" style="overflow-x: auto;">
                    <table class="monthly-table">
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
                                <th>Date Released</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($transactions as $processing)
                                @php
                                    $client = $processing->client;
                                    $categoryClass = match($client->client_category) {
                                        'Senior Citizens'
                                            => 'monthly-category--senior',
                                        'Family heads and Other Needy Adult'
                                            => 'monthly-category--family-head',
                                        'Youth in Need and Other Needy Adult'
                                            => 'monthly-category--youth',
                                        'Youth in Need of Special Protection'
                                            => 'monthly-category--youth-protection',
                                        'Men/Women in specially difficult circumstances'
                                            => 'monthly-category--difficult-circumstances',
                                        default => 'monthly-category--regular',
                                    };
                                @endphp
                                <tr>
                                    <td><span class="monthly-control-number">{{ $client->control_number }}</span></td>
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
                                    <td><span class="monthly-category {{ $categoryClass }}">{{ $client->client_category }}</span></td>
                                    <td>{{ $client->subcategory }}</td>
                                    <td>{{ $client->amount ? number_format($client->amount, 2) : '—' }}</td>
                                    <td>{{ $client->program_requested }}</td>
                                    <td>{{ $client->type_of_assistance }}</td>
                                    <td>
                                        <span class="monthly-date">
                                            {{ \Carbon\Carbon::parse($processing->end_time)->format('M d, Y h:i A') }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="26" class="monthly-empty">
                                        {{ __('No transactions for this month.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="monthly-pagination">
                    {{ $transactions->links() }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>