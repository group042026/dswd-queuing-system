<x-admin-layout>

    <style>
        /* ==========================================================================
           1. Theme Variables
           ========================================================================== */

        :root {
            /* DSWD Palette */
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

            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* ==========================================================================
           2. Dark Mode
           ========================================================================== */

        .dark .activity-filter-card,
        .dark .activity-card {
            border-color: #334155;
        }

        .dark .activity-filter-label {
            color: #94a3b8;
        }

        .dark .activity-filter-input {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }

        .dark .activity-btn-today {
            background-color: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        .dark .activity-btn-today:hover {
            background-color: #334155;
            border-color: #64748b;
        }

        .dark .activity-card__header {
            border-bottom-color: #334155;
        }

        .dark .activity-card__date {
            color: #f8fafc;
        }

        .dark .activity-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .dark .activity-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .activity-table tr:hover td {
            background-color: rgba(30, 64, 175, 0.05);
        }

        .dark .activity-pagination {
            border-top-color: #334155;
        }


        /* ==========================================================================
           3. Main Container
           ========================================================================== */

        .activity {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .activity__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }


        /* ==========================================================================
           4. Header
           ========================================================================== */

        .activity-header {
            background: linear-gradient(
                135deg,
                var(--dswd-blue) 0%,
                #1e40af 50%,
                var(--dswd-red) 100%
            );

            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);

            color: var(--text-white);
            padding: 24px;
            position: relative;
        }

        .activity-header__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .activity-header__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .activity-header__title {
            font-size: 26px;
            font-weight: 850;
            margin: 0 0 6px 0;
        }

        .activity-header__subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            margin: 0;
        }


        /* ==========================================================================
           5. Filter Panel
           ========================================================================== */

        .activity-filter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .activity-filter-form {
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .activity-filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .activity-filter-label {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
        }

        .activity-filter-input {
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            outline: none;
            transition: var(--transition-smooth);
        }

        .activity-filter-input:focus {
            border-color: var(--dswd-blue);
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.12);
        }

        .activity-btn-filter {
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

        .activity-btn-filter:hover {
            background-color: var(--dswd-blue-hover);
        }

        .activity-btn-today {
            background-color: var(--card-bg);
            border: 1.5px solid #cbd5e1;
            color: #475569;
            font-weight: 700;
            font-size: 13px;
            padding: 9px 18px;
            border-radius: 8px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: var(--transition-smooth);
        }

        .activity-btn-today:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }


        /* ==========================================================================
           6. Activity Logs Card
           ========================================================================== */

        .activity-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: 4px solid var(--dswd-blue);
            overflow: hidden;
        }

        .activity-card__header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: var(--text-muted);
        }

        .activity-card__date {
            font-weight: 700;
            color: #1e293b;
        }


        /* ==========================================================================
           7. Table
           ========================================================================== */

        .activity-table-wrapper {
            overflow-x: auto;
        }

        .activity-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .activity-table th {
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

        .activity-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }

        .activity-table tr:hover td {
            background-color: rgba(0, 56, 168, 0.015);
        }


        /* ==========================================================================
           8. Activity Badges
           ========================================================================== */

        .activity-badge {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            border: 1px solid;
            white-space: nowrap;
        }

        .activity-badge--success {
            color: var(--emerald-green);
            background-color: var(--emerald-light);
            border-color: var(--emerald-border);
        }

        .activity-badge--danger {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border-color: var(--dswd-red-border);
        }

        .activity-badge--info {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border-color: var(--dswd-blue-border);
        }


        /* ==========================================================================
           9. User
           ========================================================================== */

        .activity-user {
            display: flex;
            align-items: center;
            gap: 10px;
            white-space: nowrap;
        }

        .activity-user__avatar {
            width: 32px;
            height: 32px;
            border-radius: 9999px;
            background-color: var(--dswd-blue-light);
            border: 1px solid var(--dswd-blue-border);

            display: flex;
            align-items: center;
            justify-content: center;

            color: var(--dswd-blue);
            font-size: 12px;
            font-weight: 800;
        }

        .activity-user__name {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .dark .activity-user__name {
            color: #e2e8f0;
        }


        /* ==========================================================================
           10. Date & Time
           ========================================================================== */

        .activity-time {
            white-space: nowrap;
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
        }


        /* ==========================================================================
           11. Details
           ========================================================================== */

        .activity-details {
            min-width: 300px;
            max-width: 520px;
            font-size: 13px;
            color: #64748b;
            font-weight: 500;
            line-height: 1.5;
        }

        .dark .activity-details {
            color: #94a3b8;
        }


        /* ==========================================================================
           12. Empty State
           ========================================================================== */

        .activity-empty {
            padding: 48px 24px !important;
            text-align: center;
            color: #94a3b8 !important;
            font-weight: 600 !important;
        }


        /* ==========================================================================
           13. Pagination
           ========================================================================== */

        .activity-pagination {
            padding: 20px 24px;
            border-top: 1px solid #f1f5f9;
        }


        /* ==========================================================================
           14. Responsive
           ========================================================================== */

        @media (max-width: 640px) {

            .activity__container {
                padding: 0 16px;
            }

            .activity-header {
                padding: 20px;
            }

            .activity-header__title {
                font-size: 22px;
            }

            .activity-filter-card {
                padding: 16px;
            }

            .activity-filter-form {
                align-items: stretch;
                flex-direction: column;
            }

            .activity-btn-filter,
            .activity-btn-today {
                width: 100%;
                text-align: center;
            }

            .activity-card__header {
                padding: 16px;
            }

            .activity-table th,
            .activity-table td {
                padding: 12px 16px;
            }
        }
    </style>


    <div class="activity">

        <div class="activity__container">


            {{-- ================================================================
                 Header
                 ================================================================ --}}

            <div class="activity-header">

                {{-- Background Icon --}}
                <div class="activity-header__bg-icon">

                    <svg
                        width="240"
                        height="240"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10
                            10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92
                            C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1
                            1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41
                            0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76
                            2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"
                        />
                    </svg>

                </div>


                <div>

                    <p class="activity-header__badge">
                        DSWD Operations Control Hub
                    </p>

                    <h1 class="activity-header__title">
                        Activity Logs
                    </h1>

                    <p class="activity-header__subtitle">
                        Review and monitor user actions and system activities across all program desks
                    </p>

                </div>

            </div>


            {{-- ================================================================
                 Date Filter
                 ================================================================ --}}

            <div class="activity-filter-card">

                <form
                    method="GET"
                    action="{{ route('admin.activitylogs') }}"
                    class="activity-filter-form"
                >

                    <div class="activity-filter-group">

                        <label
                            for="date"
                            class="activity-filter-label"
                        >
                            {{ __('Select Target Date') }}
                        </label>

                        <input
                            id="date"
                            name="date"
                            type="date"
                            class="activity-filter-input"
                            value="{{ $selectedDate }}"
                        />

                    </div>


                    <button
                        type="submit"
                        class="activity-btn-filter"
                    >
                        {{ __('Filter Logs') }}
                    </button>


                    @if($selectedDate !== now()->format('Y-m-d'))

                        <a
                            href="{{ route('admin.activitylogs') }}"
                            class="activity-btn-today"
                        >
                            {{ __('Return to Today') }}
                        </a>

                    @endif

                </form>

            </div>


            {{-- ================================================================
                 Activity Logs Card
                 ================================================================ --}}

            <div class="activity-card">


                {{-- Card Header --}}

                <div class="activity-card__header">

                    {{ __('Showing activity logs for:') }}

                    <span class="activity-card__date">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </span>

                </div>


                {{-- Table --}}

                <div class="activity-table-wrapper">

                    <table class="activity-table">

                        <thead>

                            <tr>

                                <th>
                                    Date & Time
                                </th>

                                <th>
                                    User
                                </th>

                                <th>
                                    Action
                                </th>

                                <th>
                                    Details
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($logs as $log)

                                <tr>

                                    {{-- Date & Time --}}
                                    <td>

                                        <div class="activity-time">
                                            {{ $log->time_committed->format('M d, Y h:i A') }}
                                        </div>

                                    </td>


                                    {{-- User --}}
                                    <td>

                                        @if($log->user)

                                            <div class="activity-user">

                                                <div class="activity-user__avatar">

                                                    {{ strtoupper(substr($log->user->first_name, 0, 1)) }}

                                                </div>

                                                <div class="activity-user__name">

                                                    {{ $log->user->first_name }}
                                                    {{ $log->user->last_name }}

                                                </div>

                                            </div>

                                        @else

                                            <div class="activity-user">

                                                <div class="activity-user__avatar">
                                                    S
                                                </div>

                                                <div class="activity-user__name">
                                                    System
                                                </div>

                                            </div>

                                        @endif

                                    </td>


                                    {{-- Action --}}
                                    <td>

                                        @php

                                            $actionClass = match(true) {

                                                $log->action_type === 'Assistance Released'
                                                    => 'activity-badge--success',

                                                in_array($log->action_type, [
                                                    'Queue Cancelled',
                                                    'Application Returned'
                                                ])
                                                    => 'activity-badge--danger',

                                                default
                                                    => 'activity-badge--info',

                                            };

                                        @endphp


                                        <span class="activity-badge {{ $actionClass }}">
                                            {{ $log->action_type }}
                                        </span>

                                    </td>


                                    {{-- Details --}}
                                    <td>

                                        <div class="activity-details">
                                            {{ $log->details }}
                                        </div>

                                    </td>

                                </tr>


                            @empty

                                <tr>

                                    <td
                                        colspan="4"
                                        class="activity-empty"
                                    >
                                        {{ __('No activity logs for this date.') }}
                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- Pagination --}}

                <div class="activity-pagination">

                    {{ $logs->links() }}

                </div>

            </div>

        </div>

    </div>

</x-admin-layout>
