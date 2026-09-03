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

        .returned-container {
            padding: 12px 0;
            color: var(--text-primary);
        }

        /* Banner */
        .ret-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .ret-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .ret-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .ret-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .ret-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .ret-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .ret-banner__stripe {
            height: 100%;
            width: 33.333%;
        }
        .ret-banner__stripe--blue { background-color: var(--dswd-blue); }
        .ret-banner__stripe--yellow { background-color: var(--dswd-yellow); }
        .ret-banner__stripe--red { background-color: var(--dswd-red); }


        /* Filter Section */
        .filter-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .filter-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-label {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
        }

        .dark .filter-label {
            color: #94a3b8;
        }

        .filter-input {
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

        .filter-input:focus {
            border-color: var(--dswd-blue);
            box-shadow:
                0 0 0 3px rgba(0, 56, 168, 0.12);
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

        /* Table Design */
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

        /* Buttons overrides */
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
    </style>

    <div class="returned-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Banner -->
            <div class="ret-banner">
                <div class="ret-banner__content">
                    <div class="ret-banner__badge">DSWD Social Worker Portal</div>
                    <h1 class="ret-banner__title">Returned Applications</h1>
                    <p class="ret-banner__description">
                        Track, revise, and resume evaluations for applications returned by the Approving Officer.
                    </p>
                </div>
                <div class="ret-banner__ribbon">
                    <div class="ret-banner__stripe ret-banner__stripe--blue"></div>
                    <div class="ret-banner__stripe ret-banner__stripe--yellow"></div>
                    <div class="ret-banner__stripe ret-banner__stripe--red"></div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Date filter --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('social-worker.returned') }}" class="flex items-end gap-3 flex-wrap">
                    {{-- <div class="flex flex-col gap-1.5">
                        <x-input-label for="date" :value="__('Select Queue Date')" class="font-semibold text-gray-700 text-xs" />
                        <x-text-input id="date" name="date" type="date" class="block" value="{{ $selectedDate }}" />
                    </div> --}}

                    <div class="filter-group">
                        <label for="date_from" class="filter-label">
                            {{ __('From') }}
                        </label>
                        <input type="date" id="date_from" name="date_from" class="filter-input" value="{{ $dateFrom }}"/>
                    </div>
                    <div class="filter-group">
                        <label for="date_to" class="filter-label" >
                            {{ __('To') }}
                        </label>
                        <input type="date" id="date_to" name="date_to" class="filter-input" value="{{ $dateTo }}"/>
                    </div>

                    <x-primary-button type="submit" class="h-[42px] px-5 btn-primary">
                        {{ __('Filter Queue') }}
                    </x-primary-button>

                    @if($dateTo !== now()->format('Y-m-d'))
                        <a href="{{ route('social-worker.returned') }}">
                            <x-secondary-button type="button" class="h-[42px] px-5">
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="data-card">
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">{{ __('Returned Applications Queue') }}</h3>
                        <p class="text-xs text-gray-500 mt-1">
                            {{ __('Review suggestions and resume client assessments.') }}
                        </p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Queue #</th>
                                <th>Client Name</th>
                                <th>Return Remarks</th>
                                <th>Returned On</th>
                                {{-- <th>Actions</th> --}}
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($returned as $item)
                                <tr>
                                    <td class="font-bold text-gray-900">{{ $item->queue->queue_number }}</td>
                                    <td>
                                        <div class="font-extrabold text-gray-800">{{ $item->client->first_name }} {{ $item->client->last_name }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $item->client->control_number }}</div>
                                    </td>
                                    <td class="text-sm text-gray-700 max-w-xs leading-normal">
                                        <div class="bg-red-50/50 text-red-900 border border-red-100 p-2.5 rounded-lg text-xs font-semibold">
                                            {{ $item->client->assessment?->approval_remarks ?? __('No remarks provided.') }}
                                        </div>
                                    </td>
                                    <td class="text-xs text-gray-500">
                                        {{ $item->end_time?->format('M d, Y h:i A') }}
                                    </td>
                                    {{-- <td>
                                        <form method="POST" action="{{ route('social-worker.returned.resume', $item->id) }}">
                                            @csrf
                                            <x-primary-button type="submit" class="btn-primary">
                                                {{ __('Resume Assessment') }}
                                            </x-primary-button>
                                        </form>
                                    </td> --}}
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="p-8 text-center text-gray-500 italic">{{ __('No returned applications.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $returned->links() }}
                </div>
            </div>
        </div>
    </div>
</x-social-worker-layout>