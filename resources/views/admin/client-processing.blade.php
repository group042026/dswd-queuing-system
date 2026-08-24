<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Client Processing Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Real-time snapshot — walang date filter, laging current --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                <h3 class="text-sm font-semibold text-gray-500 uppercase mb-4">{{ __('Current Snapshot (Live)') }}</h3>

                <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div>
                        <p class="text-xs text-gray-500">{{ __('Total Active') }}</p>
                        <p class="text-2xl font-bold">{{ $totalStuck }}</p>
                    </div>
                    @foreach(['Validation', 'Assessment', 'Review', 'Releasing'] as $step)
                        <div>
                            <p class="text-xs text-gray-500">{{ $step }}</p>
                            <p class="text-2xl font-bold">{{ $stuckPerStage[$step] ?? 0 }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Date range filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                <form method="GET" action="{{ route('admin.client-processing') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date_from" :value="__('From')" />
                        <x-text-input id="date_from" name="date_from" type="date" class="mt-1 block"
                            value="{{ $dateFrom }}" />
                    </div>

                    <div>
                        <x-input-label for="date_to" :value="__('To')" />
                        <x-text-input id="date_to" name="date_to" type="date" class="mt-1 block"
                            value="{{ $dateTo }}" />
                    </div>

                    <x-primary-button type="submit">
                        {{ __('View') }}
                    </x-primary-button>

                    <a href="{{ route('admin.client-processing.export', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}">
                        <x-secondary-button type="button">
                            {{ __('Download Excel') }}
                        </x-secondary-button>
                    </a>
                </form>
            </div>

            {{-- Historical list --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    {{ __('Showing processing history from:') }}
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                    </span>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue Number</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Step</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Handled By</th>
                            <th class="p-3">Start Time</th>
                            <th class="p-3">End Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($processingHistory as $processing)
                            <tr class="border-b">
                                <td class="p-3 font-medium">{{ $processing->queue->queue_number ?? '—' }}</td>
                                <td class="p-3">{{ $processing->client->first_name }} {{ $processing->client->last_name }}</td>
                                <td class="p-3">{{ $processing->current_step }}</td>
                                <td class="p-3">
                                    <span @class([
                                        'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-blue-100 text-blue-800'     => $processing->current_status === 'Processing',
                                        'bg-yellow-100 text-yellow-800' => $processing->current_status === 'Waiting',
                                        'bg-green-100 text-green-800'   => $processing->current_status === 'Completed',
                                        'bg-red-100 text-red-800'       => $processing->current_status === 'Cancelled',
                                    ])>
                                        {{ $processing->current_status }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm">
                                    {{ $processing->user ? "{$processing->user->first_name} {$processing->user->last_name}" : '—' }}
                                </td>                                
                                <td class="p-3 text-sm text-gray-500">{{ $processing->start_time->format('M d, Y h:i A') }}</td>
                                <td class="p-3 text-sm text-gray-500">
                                    {{ $processing->end_time ? $processing->end_time->format('M d, Y h:i A') : '—' }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    {{ __('No processing records for this date range.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $processingHistory->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>