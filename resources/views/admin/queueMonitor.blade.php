<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue Monitoring') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            {{-- Date filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('admin.queue.monitor') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block"
                            value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit">
                        {{ __('Filter') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('admin.queue.monitor') }}">
                            <x-secondary-button type="button">
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    {{ __('Showing queue for:') }}
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </span>
                </div>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue Number</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Priority</th>
                            <th class="p-3">Current Step</th>
                            <th class="p-3">Step Status</th>
                            <th class="p-3">Status</th>
                            <th class="p-3">Date Issued</th>
                            <th class="p-3">Actions</th> 
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($queues as $queue)
                            <tr class="border-b">
                                <td class="p-3 font-medium">{{ $queue->queue_number }}</td>
                                <td class="p-3">{{ $queue->client->first_name }} {{ $queue->client->last_name }}</td>
                                <td class="p-3">
                                    @if($queue->priority)
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $queue->client->client_category }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">Regular</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($queue->latestProcessing)
                                        <span class="text-sm font-medium">{{ $queue->latestProcessing->current_step }}</span>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if($queue->latestProcessing)
                                        <span @class([
                                            'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                            'bg-blue-100 text-blue-800'     => $queue->latestProcessing->current_status === 'Serving',
                                            'bg-yellow-100 text-yellow-800' => $queue->latestProcessing->current_status === 'Waiting',
                                            'bg-green-100 text-green-800'   => $queue->latestProcessing->current_status === 'Completed',
                                        ])>
                                            {{ $queue->latestProcessing->current_status }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-sm">—</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <span @class([
                                        'inline-block px-2 py-1 text-xs font-semibold rounded-full',
                                        'bg-blue-100 text-blue-800'     => $queue->queue_status === 'Serving',
                                        'bg-yellow-100 text-yellow-800' => $queue->queue_status === 'Waiting',
                                        'bg-green-100 text-green-800'   => $queue->queue_status === 'Completed',
                                        'bg-red-100 text-red-800'       => $queue->queue_status === 'Cancelled',
                                    ])>
                                        {{ $queue->queue_status }}
                                    </span>
                                </td>
                                <td class="p-3 text-sm text-gray-500">{{ $queue->date_issued->format('M d, Y h:i A') }}</td>
                                <td class="p-3">
                                    @if(!in_array($queue->queue_status, ['Completed', 'Cancelled']))
                                        <x-danger-button type="button" x-data="" x-on:click="$dispatch('open-modal', 'cancel-queue-modal-{{ $queue->id }}')"
                                            class="inline-flex items-center gap-1.5">
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
                            @if(!in_array($queue->queue_status, ['Completed', 'Cancelled']))
                                <x-modal name="cancel-queue-modal-{{ $queue->id }}" focusable>
                                    <div class="p-6">
                                        <div class="flex items-center gap-3 mb-4">
                                            <div class="flex-shrink-0 flex items-center justify-center h-10 w-10 rounded-full bg-red-100">
                                                <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                </svg>
                                            </div>
                                            <h2 class="text-lg font-medium text-gray-900">
                                                {{ __('Cancel Queue Entry') }}
                                            </h2>
                                        </div>

                                        <p class="text-sm text-gray-600 mb-6">
                                            {{ __('Are you sure you want to cancel the queue entry for') }}
                                            <span class="font-semibold">{{ $queue->client->first_name }} {{ $queue->client->last_name }}</span>
                                            ({{ __('Queue') }} #{{ $queue->queue_number }})?
                                            {{ __('This action cannot be undone.') }}
                                        </p>

                                        <form method="POST" action="{{ route('admin.queue.cancel', $queue->id) }}">
                                            @csrf
                                            @method('PATCH')

                                            <div class="flex justify-end gap-3">
                                                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'cancel-queue-modal-{{ $queue->id }}')">
                                                    {{ __('Close') }}
                                                </x-secondary-button>
                                                <x-danger-button type="submit">
                                                    {{ __('Cancel Queue') }}
                                                </x-danger-button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="p-3 text-center text-gray-500">
                                    {{ __('No queue entries for this date.') }}
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