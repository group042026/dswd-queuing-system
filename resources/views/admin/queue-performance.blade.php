<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue Performance Report') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Date range filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-4">
                <form method="GET" action="{{ route('admin.queue-performance') }}" class="flex items-end gap-3">
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

                    <a href="{{ route('admin.queue-performance.export', ['date_from' => $dateFrom, 'date_to' => $dateTo]) }}">
                        <x-secondary-button type="button">
                            {{ __('Download Excel') }}
                        </x-secondary-button>
                    </a>
                </form>
            </div>

            {{-- Summary cards --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase">{{ __('Total Queues') }}</p>
                    <p class="text-3xl font-bold mt-1">{{ $totalQueues }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Served (by Status)') }}</p>
                    @forelse($servedCount as $status => $count)
                        <div class="flex justify-between text-sm py-1">
                            <span class="text-gray-600">{{ $status }}</span>
                            <span class="font-semibold">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">{{ __('No data') }}</p>
                    @endforelse
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <p class="text-xs font-semibold text-gray-500 uppercase mb-2">{{ __('Avg Time per Step (mins)') }}</p>
                    @forelse($avgTimePerStep as $step => $minutes)
                        <div class="flex justify-between text-sm py-1">
                            <span class="text-gray-600">{{ $step }}</span>
                            <span class="font-semibold">{{ round($minutes, 1) }}</span>
                        </div>
                    @empty
                        <p class="text-sm text-gray-400">{{ __('No data') }}</p>
                    @endforelse
                </div>
            </div>
            {{-- Detailed list --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    {{ __('Showing queues from:') }}
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($dateFrom)->format('M d, Y') }} — {{ \Carbon\Carbon::parse($dateTo)->format('M d, Y') }}
                    </span>
                </div>
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue Number</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Priority</th>
                            <th class="p-3">Queue Status</th>
                            <th class="p-3">Total Duration</th>
                            <th class="p-3">Current Step</th>
                            <th class="p-3">Date Issued</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $queue)
                            <tr class="border-b">
                                <td class="p-3 font-medium">{{ $queue->queue_number }}</td>
                                <td class="p-3">{{ $queue->client->first_name }} {{ $queue->client->last_name }}</td>
                                <td class="p-3">
                                    @if($queue->priority)
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Yes</span>
                                    @else
                                        <span class="text-gray-400 text-sm">No</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <span @class([
                                        'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-blue-100 text-blue-800'   => $queue->queue_status === 'Serving',
                                        'bg-yellow-100 text-yellow-800' => $queue->queue_status === 'Waiting',
                                        'bg-green-100 text-green-800' => $queue->queue_status === 'Completed',
                                        'bg-red-100 text-red-800'     => $queue->queue_status === 'Cancelled',
                                    ])>
                                        {{ $queue->queue_status }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm">
                                    @if(in_array($queue->queue_status, ['Completed', 'Cancelled']) && $queue->latestProcessing?->end_time)
                                        @php
                                            $duration = \Carbon\Carbon::parse($queue->date_issued)->diffForHumans($queue->latestProcessing->end_time, true);
                                        @endphp
                                        {{ $duration }}
                                    @else
                                        <span class="text-gray-400 italic">In Progress</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm">{{ $queue->latestProcessing->current_step ?? '—' }}</td>
                                <td class="p-3 text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($queue->date_issued)->format('M d, Y h:i A') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-3 text-center text-gray-500">
                                    {{ __('No queues for this date range.') }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $queues->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>