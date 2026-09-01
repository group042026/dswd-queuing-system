<x-admin-layout>
    <style>
        /* ==========================================================================
           1. Theme Variable Configuration
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
            --dswd-yellow-hover: #e0b800;
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

        .dark {
            --bg-gray: #0f172a;
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

        .dark .filter-card {
            border-color: #334155;
        }

        .dark .filter-form__label {
            color: #94a3b8;
        }

        .dark .filter-form__input {
            background-color: #1e293b;
            border-color: #475569;
            color: #f1f5f9;
        }

        .dark .btn-today {
            background-color: #1e293b;
            border-color: #475569;
            color: #cbd5e1;
        }

        .dark .btn-today:hover {
            background-color: #334155;
            border-color: #64748b;
        }

        .dark .monitor-card {
            border-color: #334155;
        }

        .dark .monitor-card__header {
            border-bottom-color: #334155;
        }

        .dark .monitor-card__date {
            color: #f8fafc;
        }

        .dark .monitor-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .dark .monitor-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .monitor-table tr:hover td {
            background-color: rgba(30, 64, 175, 0.05);
        }

        .dark .badge-queue-no {
            color: var(--dswd-yellow);
        }

        .dark .monitor-pagination {
            border-top-color: #334155;
        }

        .monitor {
            padding: 24px 0;
            /* background-color: var(--bg-gray); */
            min-height: 100vh;
            color: var(--text-primary);
        }

        .monitor__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Header Component */
        .monitor-header {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            color: var(--text-white);
            padding: 24px;
            position: relative;
        }

        .monitor-header__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.08;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .monitor-header__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 4px;
        }

        .monitor-header__title {
            font-size: 26px;
            font-weight: 850;
            margin: 0 0 6px 0;
        }

        .monitor-header__subtitle {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            margin: 0;
        }

        /* Filter Panel */
        .filter-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 16px 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
            border: 1px solid #f1f5f9;
        }

        .filter-form {
            display: flex;
            align-items: flex-end;
            flex-wrap: wrap;
            gap: 16px;
        }

        .filter-form__group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .filter-form__label {
            font-size: 12px;
            font-weight: 700;
            color: #475569;
        }

        .filter-form__input {
            border-radius: 8px;
            border: 1.5px solid #cbd5e1;
            padding: 8px 12px;
            font-size: 14px;
            font-weight: 600;
            outline: none;
            transition: var(--transition-smooth);
        }

        .filter-form__input:focus {
            border-color: var(--dswd-blue);
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.12);
        }

        .btn-filter {
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

        .btn-filter:hover {
            background-color: var(--dswd-blue-hover);
        }

        .btn-today {
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

        .btn-today:hover {
            background-color: #f8fafc;
            border-color: #94a3b8;
        }

        /* Monitor Panel */
        .monitor-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border: 1px solid #f1f5f9;
            border-top: 4px solid var(--dswd-blue);
            overflow: hidden;
        }

        .monitor-card__header {
            padding: 20px 24px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 14px;
            color: var(--text-muted);
        }

        .monitor-card__date {
            font-weight: 700;
            color: #1e293b;
        }

        /* Table Design */
        .monitor-table-wrapper {
            overflow-x: auto;
        }

        .monitor-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            font-size: 14px;
        }

        .monitor-table th {
            background-color: #f8fafc;
            color: var(--text-muted);
            font-weight: 700;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            padding: 14px 24px;
            border-bottom: 1px solid #e2e8f0;
        }

        .monitor-table td {
            padding: 16px 24px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-weight: 600;
            vertical-align: middle;
        }

        .monitor-table tr:hover td {
            background-color: rgba(0, 56, 168, 0.015);
        }

        /* Badge Components */
        .badge-queue-no {
            font-family: monospace;
            font-size: 15px;
            font-weight: 900;
            color: var(--dswd-blue);
        }

        .badge-priority {
            font-size: 10px;
            font-weight: 700;
            padding: 3px 8px;
            border-radius: 4px;
            border: 1px solid;
            display: inline-block;
        }

        .badge-priority--senior {
            color: #1d4ed8;
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }

        .badge-priority--family-heads {
            color: #047857;
            background-color: #ecfdf5;
            border-color: #a7f3d0;
        }

        .badge-priority--youth-needy-adult {
            color: #7e22ce;
            background-color: #faf5ff;
            border-color: #e9d5ff;
        }

        .badge-priority--youth-protection {
            color: #b91c1c;
            background-color: #fef2f2;
            border-color: #fecaca;
        }

        .badge-priority--difficult-circumstances {
            color: #c2410c;
            background-color: #fff7ed;
            border-color: #fed7aa;
        }

        .badge-priority--default {
            color: #475569;
            background-color: #f8fafc;
            border-color: #e2e8f0;
        }

        .badge-status {
            display: inline-block;
            padding: 4px 10px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 9999px;
            border: 1px solid;
        }

        .badge-status--serving {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border-color: var(--dswd-blue-border);
        }

        .badge-status--waiting {
            color: #b45309;
            background-color: #fffbeb;
            border-color: #fde68a;
        }

        .badge-status--completed {
            color: var(--emerald-green);
            background-color: var(--emerald-light);
            border-color: var(--emerald-border);
        }

        .badge-status--cancelled {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border-color: var(--dswd-red-border);
        }

        /* Pagination container */
        .monitor-pagination {
            padding: 20px 24px;
            border-top: 1px solid #f1f5f9;
        }
    </style>

    <div class="monitor">
        <div class="monitor__container">

            <!-- Welcome Header Panel -->
            <div class="monitor-header">
                <!-- Subtle background logo mark -->
                <div class="monitor-header__bg-icon">
                    <svg width="240" height="240" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                    </svg>
                </div>
                <div class="monitor-header__info">
                    <p class="monitor-header__badge">DSWD Operations Control Hub</p>
                    <h1 class="monitor-header__title">Queue Monitoring Panel</h1>
                    <p class="monitor-header__subtitle">Track issuing times, steps status, and cancellations across all program desks</p>
                </div>
            </div>

            {{-- Date Filter Section --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('admin.queue.monitor') }}" class="filter-form">
                    <div class="filter-form__group">
                        <label for="date" class="filter-form__label">{{ __('Select Target Date') }}</label>
                        <input id="date" name="date" type="date" class="filter-form__input" value="{{ $selectedDate }}" />
                    </div>

                    <button type="submit" class="btn-filter">
                        {{ __('Filter Schedule') }}
                    </button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('admin.queue.monitor') }}" class="btn-today">
                            {{ __('Return to Today') }}
                        </a>
                    @endif
                </form>
            </div>

            {{-- Queue List Card --}}
            <div class="monitor-card">
                <div class="monitor-card__header">
                    {{ __('Showing queue details for:') }}
                    <span class="monitor-card__date">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </span>
                </div>

                <div class="monitor-table-wrapper">
                    <table class="monitor-table">
                        <thead>
                            <tr>
                                <th>Queue Number</th>
                                <th>Client Name</th>
                                <th>Category</th>
                                <th>Current Step</th>
                                <th>Step Status</th>
                                <th>Ticket Status</th>
                                <th>Date Issued</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody data-queue-list>
                            @forelse($queues as $queue)
                                <tr>
                                    <td>
                                        <span class="badge-queue-no">{{ $queue->queue_number }}</span>
                                    </td>
                                    <td>{{ $queue->client->first_name }} {{ $queue->client->last_name }}</td>
                                    <td>
                                        @if($queue->priority)
                                            @php
                                                $priorityModifier = match($queue->client->client_category) {
                                                    'Senior'
                                                        => 'badge-priority--senior',

                                                    'Family heads and Other Needy Adult'
                                                        => 'badge-priority--family-heads',

                                                    'Youth in Need and Other Needy Adult'
                                                        => 'badge-priority--youth-needy-adult',

                                                    'Youth in Need of Special Protection'
                                                        => 'badge-priority--youth-protection',

                                                    'Men/Women in specially difficult circumstances'
                                                        => 'badge-priority--difficult-circumstances',

                                                    default
                                                        => 'badge-priority--default',
                                                };
                                            @endphp

                                            <span class="badge-priority {{ $priorityModifier }}">
                                                {{ $queue->client->client_category }}
                                            </span>
                                        @else
                                            <span class="badge-priority badge-priority--default">
                                                {{ $queue->client->client_category }}
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($queue->latestProcessing)
                                            <span>{{ $queue->latestProcessing->current_step }}</span>
                                        @else
                                            <span class="text-gray-400 text-sm">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($queue->latestProcessing)
                                            @php
                                                $stepStatus = $queue->latestProcessing->current_status;
                                                $stepClass = match($stepStatus) {
                                                    'Serving'               => 'badge-status--serving',
                                                    'Waiting'               => 'badge-status--waiting',
                                                    'Completed', 'Approved' => 'badge-status--completed',
                                                    'Cancelled'             => 'badge-status--cancelled',
                                                    default                 => ''
                                                };
                                            @endphp
                                            <span class="badge-status {{ $stepClass }}">
                                                {{ $stepStatus }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 text-sm">—</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $qStatus = $queue->queue_status;
                                            $qClass = match($qStatus) {
                                                'Serving'               => 'badge-status--serving',
                                                'Waiting'               => 'badge-status--waiting',
                                                'Completed'             => 'badge-status--completed',
                                                'Cancelled', 'No Show'  => 'badge-status--cancelled',
                                                default                 => ''
                                            };
                                        @endphp
                                        <span class="badge-status {{ $qClass }}">
                                            {{ $qStatus }}
                                        </span>
                                    </td>
                                    <td class="text-sm text-gray-500">{{ $queue->date_issued->format('M d, Y h:i A') }}</td>
                                    <td>
                                        @if(!in_array($queue->queue_status, ['Completed', 'Cancelled', 'Abondoned']))
                                            <x-danger-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'cancel-queue-modal-{{ $queue->id }}')"
                                                class="inline-flex items-center gap-1.5" style="border-radius: 8px;">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                {{ __('Cancel') }}
                                            </x-danger-button>
                                        @else
                                            <span class="text-gray-300 text-xs">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-gray-400 font-semibold">
                                        No queuing tickets issued for this date.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Modal --}}
                <div data-modal-container>
                    @foreach($queues as $queue)
                        @if(!in_array($queue->queue_status, ['Completed', 'Cancelled', 'Abondoned']))
                            <x-modal name="cancel-queue-modal-{{ $queue->id }}" focusable>
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-bold text-gray-900">
                                            {{ __('Cancel Queue Entry') }}
                                        </h2>
                                    </div>

                                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                                        Are you sure you want to cancel the queue entry for
                                        <span class="font-bold text-gray-800">{{ $queue->client->first_name }} {{ $queue->client->last_name }}</span>
                                        (<span class="font-mono text-gray-900 font-bold">Queue #{{ $queue->queue_number }}</span>)?
                                        This action cannot be undone and will record the ticket as cancelled.
                                    </p>

                                    <form method="POST" action="{{ route('admin.queue.cancel', $queue->id) }}">
                                        @csrf
                                        @method('PATCH')

                                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'cancel-queue-modal-{{ $queue->id }}')">
                                                {{ __('Close') }}
                                            </x-secondary-button>
                                            <x-danger-button type="submit" style="border-radius: 8px;">
                                                {{ __('Cancel Queue') }}
                                            </x-danger-button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        @endif
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="monitor-pagination" data-pagination>
                    {{ $queues->links() }}
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function getStepStatusClass(status) {
            const map = {
                'Serving': 'badge-status--serving',
                'Waiting': 'badge-status--waiting',
                'Completed': 'badge-status--completed',
                'Approved': 'badge-status--completed',
                'Cancelled': 'badge-status--cancelled',
            };
            return map[status] || '';
        }

        function getQueueStatusClass(status) {
            const map = {
                'Serving': 'badge-status--serving',
                'Waiting': 'badge-status--waiting',
                'Completed': 'badge-status--completed',
                'Cancelled': 'badge-status--cancelled',
                'No Show': 'badge-status--cancelled',
            };
            return map[status] || '';
        }

        function getPriorityClass(category) {
            const map = {
                'Senior': 'badge-priority--senior',

                'Family heads and Other Needy Adult':
                    'badge-priority--family-heads',

                'Youth in Need and Other Needy Adult':
                    'badge-priority--youth-needy-adult',

                'Youth in Need of Special Protection':
                    'badge-priority--youth-protection',

                'Men/Women in specially difficult circumstances':
                    'badge-priority--difficult-circumstances',
            };

            return map[category] || 'badge-priority--default';
        }

        function renderQueueTable(queues) {
            if (queues.length === 0) {
                return {
                    rows: `<tr><td colspan="8" class="p-8 text-center text-gray-400 font-semibold">No queuing tickets issued for this date.</td></tr>`,
                    modals: '',
                };
            }

            let rows = '';
            let modals = '';

            queues.forEach(q => {
                const priorityBadge = `
                    <span class="badge-priority ${getPriorityClass(q.client_category)}">
                        ${q.client_category}
                    </span>
                `;

                const stepCell = q.current_step
                    ? `<span>${q.current_step}</span>`
                    : `<span class="text-gray-400 text-sm">—</span>`;

                const stepStatusCell = q.current_status
                    ? `<span class="badge-status ${getStepStatusClass(q.current_status)}">${q.current_status}</span>`
                    : `<span class="text-gray-400 text-sm">—</span>`;

                const cancelCell = q.can_cancel
                    ? `<button type="button" class="inline-flex items-center gap-1.5 px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" style="border-radius: 8px;" x-data="" x-on:click="$dispatch('open-modal', 'cancel-queue-modal-${q.id}')">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                        Cancel
                       </button>`
                    : `<span class="text-gray-300 text-xs">—</span>`;

                rows += `
                    <tr>
                        <td><span class="badge-queue-no">${q.queue_number}</span></td>
                        <td>${q.client_name}</td>
                        <td>${priorityBadge}</td>
                        <td>${stepCell}</td>
                        <td>${stepStatusCell}</td>
                        <td><span class="badge-status ${getQueueStatusClass(q.queue_status)}">${q.queue_status}</span></td>
                        <td class="text-sm text-gray-500">${q.date_issued}</td>
                        <td>${cancelCell}</td>
                    </tr>
                `;

                if (q.can_cancel) {
                    modals += `
                        <div x-data="{
                                show: false,
                                focusables() {
                                    let selector = 'a, button, input:not([type=\\'hidden\\']), textarea, select, details, [tabindex]:not([tabindex=\\'-1\\'])'
                                    return [...$el.querySelectorAll(selector)].filter(el => ! el.hasAttribute('disabled'))
                                },
                                firstFocusable() { return this.focusables()[0] },
                            }"
                            x-init="$watch('show', value => {
                                if (value) { document.body.classList.add('overflow-y-hidden'); setTimeout(() => firstFocusable().focus(), 100) }
                                else { document.body.classList.remove('overflow-y-hidden') }
                            })"
                            x-on:open-modal.window="$event.detail == 'cancel-queue-modal-${q.id}' ? show = true : null"
                            x-on:close-modal.window="$event.detail == 'cancel-queue-modal-${q.id}' ? show = false : null"
                            x-on:close.stop="show = false"
                            x-on:keydown.escape.window="show = false"
                            x-show="show"
                            class="fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50"
                            style="display: none;"
                        >
                            <div x-show="show" class="fixed inset-0 transform transition-all" x-on:click="show = false"
                                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
                                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                            </div>
                            <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-2xl sm:mx-auto"
                                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                                <div class="p-6">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                            </svg>
                                        </div>
                                        <h2 class="text-lg font-bold text-gray-900">Cancel Queue Entry</h2>
                                    </div>
                                    <p class="text-sm text-gray-600 mb-6 leading-relaxed">
                                        Are you sure you want to cancel the queue entry for
                                        <span class="font-bold text-gray-800">${q.client_name}</span>
                                        (<span class="font-mono text-gray-900 font-bold">Queue #${q.queue_number}</span>)?
                                        This action cannot be undone and will record the ticket as cancelled.
                                    </p>
                                    <form method="POST" action="${q.cancel_url}">
                                        <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                        <input type="hidden" name="_method" value="PATCH">
                                        <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                                            <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 disabled:opacity-25 transition ease-in-out duration-150" x-on:click="$dispatch('close-modal', 'cancel-queue-modal-${q.id}')">Close</button>
                                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150" style="border-radius: 8px;">Cancel Queue</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    `;
                }
            });

            return { rows, modals };
        }

        window.Echo.channel('admin-dashboard')
            .listen('.dashboard.updated', () => {
                const params = new URLSearchParams(window.location.search);

                fetch(`{{ route('admin.queue.monitor.data') }}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.isToday) return;

                        const { rows, modals } = renderQueueTable(data.queues);

                        document.querySelector('[data-queue-list]').innerHTML = rows;
                        document.querySelector('[data-modal-container]').innerHTML = modals;

                        const paginationEl = document.querySelector('[data-pagination]');
                        if (paginationEl) paginationEl.innerHTML = data.pagination;
                    });
            });
    });
</script>
@endpush
</x-admin-layout>
