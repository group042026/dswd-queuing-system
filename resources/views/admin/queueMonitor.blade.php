<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Queue Monitoring') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue Number</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Priority</th>
                            <th class="p-3">Client Category</th>

                            <th class="p-3">Status</th>
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
                                        <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Priority</span>
                                    @else
                                        <span class="text-gray-400 text-sm">Regular</span>
                                    @endif
                                </td>
                                <td class="p-3 text-sm text-gray-600">{{ $queue->client->client_category }}</td>
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
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">No queue entries yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{ $queues->links() }}
            </div>
        </div>
    </div>
</x-admin-layout>