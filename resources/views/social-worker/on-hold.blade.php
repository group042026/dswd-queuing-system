<x-social-worker-layout>
    <style>
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
            --dswd-yellow-hover: #e0b800;
            --dswd-yellow-light: rgba(252, 209, 22, 0.12);

            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .on-hold-container {
            padding: 12px 0;
            color: var(--text-primary);
        }

        /* Banner */
        .hold-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .hold-banner__content {
            background: linear-gradient(
                135deg,
                var(--dswd-blue) 0%,
                #1e40af 50%,
                var(--dswd-red) 100%
            );
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .hold-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .hold-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .hold-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .hold-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .hold-banner__stripe {
            height: 100%;
            width: 33.333%;
        }

        .hold-banner__stripe--blue {
            background-color: var(--dswd-blue);
        }

        .hold-banner__stripe--yellow {
            background-color: var(--dswd-yellow);
        }

        .hold-banner__stripe--red {
            background-color: var(--dswd-red);
        }

        /* Success Alert */
        .hold-alert {
            margin-bottom: 24px;
            padding: 16px;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #047857;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 14px;
            font-weight: 600;
        }

        /* Main Data Card */
        .data-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        /* Table */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .custom-table tr:hover td {
            background-color: #f8fafc;
        }

        /* Hold Reason */
        .hold-reason {
            max-width: 320px;
            padding: 10px 12px;
            border-radius: 8px;
            background-color: #fffbeb;
            border: 1px solid #fde68a;
            color: #92400e;
            font-size: 12px;
            font-weight: 600;
            line-height: 1.5;
        }

        /* Resume Button */
        .btn-primary {
            background-color: var(--dswd-blue) !important;
            color: var(--text-white) !important;
            font-weight: 800 !important;
            border-radius: 8px !important;
            transition: var(--transition-smooth) !important;
            border: none !important;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: var(--dswd-blue-hover) !important;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .on-hold-container {
                padding: 16px 0;
            }

            .hold-banner__content {
                padding: 22px 20px;
            }

            .hold-banner__title {
                font-size: 22px;
            }

            .data-card {
                padding: 16px;
            }

            .custom-table th,
            .custom-table td {
                white-space: nowrap;
            }
        }
    </style>

    <div class="on-hold-container">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Header Banner --}}
            <div class="hold-banner">
                <div class="hold-banner__content">
                    <div class="hold-banner__badge">
                        DSWD Social Worker Portal
                    </div>

                    <h1 class="hold-banner__title">
                        On Hold Assessments
                    </h1>

                    <p class="hold-banner__description">
                        Monitor client assessments that are temporarily on hold due to missing documents or follow-up requirements.
                    </p>
                </div>

                <div class="hold-banner__ribbon">
                    <div class="hold-banner__stripe hold-banner__stripe--blue"></div>
                    <div class="hold-banner__stripe hold-banner__stripe--yellow"></div>
                    <div class="hold-banner__stripe hold-banner__stripe--red"></div>
                </div>
            </div>

            {{-- Success Notification --}}
            @if (session('success'))
                <div class="hold-alert">
                    <svg
                        class="w-5 h-5 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 01-18 0z"
                        />
                    </svg>

                    <span>
                        {{ session('success') }}
                    </span>
                </div>
            @endif

            {{-- Main Data Card --}}
            <div class="data-card">

                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">
                            {{ __('Clients Currently On Hold') }}
                        </h3>

                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Clients temporarily waiting for missing documents or follow-up requirements.') }}
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Queue #</th>
                                <th>Client Name</th>
                                <th>Reason</th>
                                <th>On Hold Since</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ($onHoldAssessments as $item)
                                <tr>

                                    {{-- Queue Number --}}
                                    <td class="font-bold text-gray-900">
                                        {{ $item->queue->queue_number }}
                                    </td>

                                    {{-- Client --}}
                                    <td>
                                        <div class="font-extrabold text-gray-800">
                                            {{ $item->client->first_name }}
                                            {{ $item->client->last_name }}
                                        </div>

                                        <div class="text-xs text-gray-400 font-mono mt-0.5">
                                            {{ $item->client->control_number }}
                                        </div>
                                    </td>

                                    {{-- Reason --}}
                                    <td>
                                        <div class="hold-reason">
                                            {{ $item->on_hold_reason }}
                                        </div>
                                    </td>

                                    {{-- On Hold Since --}}
                                    <td class="text-xs text-gray-500">
                                        {{ $item->on_hold_at?->format('M d, Y h:i A') }}
                                    </td>

                                    {{-- Action --}}
                                    <td>
                                        <form
                                            method="POST"
                                            action="{{ route('social-worker.assessment.resume', $item) }}"
                                        >
                                            @csrf
                                            @method('PATCH')

                                            <x-primary-button
                                                type="submit"
                                                class="btn-primary"
                                            >
                                                {{ __('Resume') }}
                                            </x-primary-button>
                                        </form>
                                    </td>

                                </tr>
                            @empty

                                <tr>
                                    <td
                                        colspan="5"
                                        class="p-8 text-center text-gray-500 italic"
                                    >
                                        {{ __('No clients are currently on hold.') }}
                                    </td>
                                </tr>

                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $onHoldAssessments->links() }}
                </div>

            </div>

        </div>
    </div>
</x-social-worker-layout>