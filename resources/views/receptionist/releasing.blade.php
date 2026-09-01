<x-receptionist-layout>
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

        .releasing-container {
            padding: 12px 0;
            color: var(--text-primary);
        }

        /* Banner */
        .val-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .val-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .val-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .val-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .val-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .val-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .val-banner__stripe {
            height: 100%;
            width: 33.333%;
        }
        .val-banner__stripe--blue { background-color: var(--dswd-blue); }
        .val-banner__stripe--yellow { background-color: var(--dswd-yellow); }
        .val-banner__stripe--red { background-color: var(--dswd-red); }

        /* Filter Section */
        .filter-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
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

        /* Category Badge */
        .category-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            display: inline-block;
        }

        .queue-row__category--senior {
            color: #1d4ed8;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .queue-row__category--familyheadsandotherneedyadult {
            color: #047857;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .queue-row__category--youthinneedandotherneedyadult {
            color: #7e22ce;
            background-color: #faf5ff;
            border: 1px solid #e9d5ff;
        }

        .queue-row__category--youthinneedofspecialprotection {
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }

        .queue-row__category--men-womeninspeciallydifficultcircumstances {
            color: #c2410c;
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
        }

        .queue-row__category--default {
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        /* Form Controls */
        .max-w-6xl input[type="date"],
        .max-w-6xl select,
        .max-w-6xl textarea {
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            color: var(--text-primary);
        }

        .max-w-6xl input[type="date"]:focus,
        .max-w-6xl select:focus,
        .max-w-6xl textarea:focus {
            outline: none !important;
            border-color: var(--dswd-blue) !important;
            box-shadow: 0 0 0 3px var(--dswd-blue-light) !important;
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

    <div class="releasing-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Banner -->
            <div class="val-banner">
                <div class="val-banner__content">
                    <div class="val-banner__badge">DSWD Receptionist Portal</div>
                    <h1 class="val-banner__title">Releasing Management</h1>
                    <p class="val-banner__description">
                        Finalize assistance distribution, record notes, and confirm receipt of approved assistance for queued clients.
                    </p>
                </div>
                <div class="val-banner__ribbon">
                    <div class="val-banner__stripe val-banner__stripe--blue"></div>
                    <div class="val-banner__stripe val-banner__stripe--yellow"></div>
                    <div class="val-banner__stripe val-banner__stripe--red"></div>
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
                <form method="GET" action="{{ route('receptionist.releasing') }}" class="flex items-end gap-3 flex-wrap">
                    <div class="flex flex-col gap-1.5">
                        <x-input-label for="date" :value="__('Select Queue Date')" class="font-semibold text-gray-700 text-xs" />
                        <x-text-input id="date" name="date" type="date" class="block" value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit" class="h-[42px] px-5 btn-primary">
                        {{ __('Filter Queue') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('receptionist.releasing') }}">
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
                        <h3 class="text-lg font-extrabold text-gray-800">{{ __('Pending Releasing List') }}</h3>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ __('Showing pending releasing for:') }}
                            <span class="font-bold text-gray-700">
                                {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Queue #</th>
                                <th>Client Name</th>
                                <th>Category</th>
                                <th>Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody data-releasing-list>
                            @php $isToday = $selectedDate === now()->format('Y-m-d'); @endphp
                            @forelse($pendingReleasing as $item)
                                <tr>
                                    <td class="font-bold text-gray-900">{{ $item->queue->queue_number }}</td>
                                    <td>
                                        <div class="font-extrabold text-gray-800">{{ $item->client->first_name }} {{ $item->client->last_name }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $item->client->control_number ?? '' }}</div>
                                    </td>
                                    <td>
                                        <span class="queue-row__category queue-row__category--{{ strtolower(str_replace([' ', '/'], ['', '-'], $item->client->client_category)) }}">
                                            {{ $item->client->client_category }}
                                        </span>
                                    </td>
                                    <td class="font-medium text-gray-700">
                                        {{ $item->client->program_requested }}
                                    </td>
                                    <td>
                                        @if($isToday)
                                            <x-primary-button x-on:click="$dispatch('open-modal', 'release-modal-{{ $item->id }}')" class="btn-primary">
                                                {{ __('Release') }}
                                            </x-primary-button>
                                        @else
                                            <x-secondary-button type="button" disabled class="opacity-50 cursor-not-allowed">
                                                {{ __('View Only') }}
                                            </x-secondary-button>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 italic">{{ __('No clients pending releasing.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Modals --}}
                <div data-modal-container>
                    @if($isToday)
                        @foreach($pendingReleasing as $item)
                            <x-modal name="release-modal-{{ $item->id }}" maxWidth="lg">
                                <div class="p-6">
                                    <div class="border-b pb-4 mb-4">
                                        <h2 class="text-lg font-extrabold text-gray-800">
                                            {{ __('Release Assistance') }}
                                        </h2>
                                        <p class="text-sm text-gray-500 mt-1">
                                            Client: <span class="font-semibold text-gray-700">{{ $item->client->first_name }} {{ $item->client->last_name }}</span>
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-2 gap-4 mb-6 bg-slate-50 p-4 rounded-xl text-sm border border-slate-100">
                                        <div>
                                            <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Client Category') }}</span>
                                            <span class="font-semibold text-gray-700">{{ $item->client->client_category }}</span>
                                        </div>
                                        <div>
                                            <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Program Requested') }}</span>
                                            <span class="font-semibold text-gray-700">{{ $item->client->program_requested }}</span>
                                        </div>
                                    </div>
                                    <form method="POST" action="{{ route('receptionist.releasing.release', $item->id) }}">
                                        @csrf
                                        <div class="mb-4">
                                            <x-input-label for="remarks_{{ $item->id }}" :value="__('Remarks (Optional)')" class="font-semibold text-gray-700 text-xs mb-1.5" />
                                            <textarea id="remarks_{{ $item->id }}" name="remarks" rows="3"
                                                class="w-full"
                                                placeholder="{{ __('e.g. Released to client personally, claimed by representative, etc.') }}">{{ old('remarks') }}</textarea>
                                        </div>
                                        <div class="flex justify-end gap-3 mt-6 border-t pt-4">
                                            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'release-modal-{{ $item->id }}')">
                                                {{ __('Close') }}
                                            </x-secondary-button>
                                            <x-primary-button type="submit" class="btn-primary">
                                                {{ __('Confirm Release') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        @endforeach
                    @endif
                </div>

                <div class="mt-6" data-pagination>
                    {{ $pendingReleasing->links() }}
                </div>
            </div>
        </div>
    </div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        let isAnyModalOpen = false;

        window.addEventListener('open-modal', () => { isAnyModalOpen = true; });
        window.addEventListener('close-modal', () => { isAnyModalOpen = false; });

        function getCategoryClass(category) {
            return category.toLowerCase().replace(/[\s\/]+/g, m => m === '/' ? '-' : '');
        }

        function renderRow(item) {
            const actionCell = item.can_release !== false
                ? `<x-primary-button x-on:click="$dispatch('open-modal', 'release-modal-${item.id}')" class="btn-primary">Release</x-primary-button>`
                : '';

            return `
                <tr>
                    <td class="font-bold text-gray-900">${item.queue_number}</td>
                    <td>
                        <div class="font-extrabold text-gray-800">${item.full_name}</div>
                        <div class="text-xs text-gray-400 font-mono mt-0.5">${item.control_number}</div>
                    </td>
                    <td>
                        <span class="queue-row__category queue-row__category--${item.category_class}">${item.client_category}</span>
                    </td>
                    <td class="font-medium text-gray-700">${item.program_requested}</td>
                    <td>
                        <button type="button" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150" x-data="" x-on:click="$dispatch('open-modal', 'release-modal-${item.id}')">
                            Release
                        </button>
                    </td>
                </tr>
            `;
        }

        function renderModal(item) {
            return `
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
                    x-on:open-modal.window="$event.detail == 'release-modal-${item.id}' ? show = true : null"
                    x-on:close-modal.window="$event.detail == 'release-modal-${item.id}' ? show = false : null"
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
                    <div x-show="show" class="mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:max-w-lg sm:mx-auto"
                         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <div class="p-6">
                            <div class="border-b pb-4 mb-4">
                                <h2 class="text-lg font-extrabold text-gray-800">Release Assistance</h2>
                                <p class="text-sm text-gray-500 mt-1">Client: <span class="font-semibold text-gray-700">${item.full_name}</span></p>
                            </div>
                            <div class="grid grid-cols-2 gap-4 mb-6 bg-slate-50 p-4 rounded-xl text-sm border border-slate-100">
                                <div>
                                    <span class="text-xs text-gray-400 block uppercase font-bold">Client Category</span>
                                    <span class="font-semibold text-gray-700">${item.client_category}</span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 block uppercase font-bold">Program Requested</span>
                                    <span class="font-semibold text-gray-700">${item.program_requested}</span>
                                </div>
                            </div>
                            <form method="POST" action="${item.release_url}">
                                <input type="hidden" name="_token" value="${document.querySelector('meta[name=csrf-token]').content}">
                                <div class="mb-4">
                                    <label class="font-semibold text-gray-700 text-xs mb-1.5 block">Remarks (Optional)</label>
                                    <textarea name="remarks" rows="3" class="w-full" placeholder="e.g. Released to client personally, claimed by representative, etc."></textarea>
                                </div>
                                <div class="flex justify-end gap-3 mt-6 border-t pt-4">
                                    <button type="button" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150" x-on:click="$dispatch('close-modal', 'release-modal-${item.id}')">Close</button>
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">Confirm Release</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            `;
        }

        window.Echo.channel('receptionist-dashboard')
            .listen('.dashboard.updated', () => {
                if (isAnyModalOpen) return; // May bukas na modal — huwag i-refresh, baka masira yung natype

                const params = new URLSearchParams(window.location.search);

                fetch(`{{ route('receptionist.releasing.data') }}?${params.toString()}`)
                    .then(response => response.json())
                    .then(data => {
                        const rows = data.items.length > 0
                            ? data.items.map(renderRow).join('')
                            : `<tr><td colspan="5" class="p-8 text-center text-gray-500 italic">No clients pending releasing.</td></tr>`;

                        document.querySelector('[data-releasing-list]').innerHTML = rows;

                        const modalContainer = document.querySelector('[data-modal-container]');
                        modalContainer.innerHTML = data.isToday ? data.items.map(renderModal).join('') : '';

                        const paginationEl = document.querySelector('[data-pagination]');
                        if (paginationEl) paginationEl.innerHTML = data.pagination;
                    });
            });
    });
</script>
@endpush
</x-receptionist-layout>