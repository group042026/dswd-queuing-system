<x-social-worker-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Returned Applications') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Returned Applications') }}</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue #</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Return Remarks</th>
                            <th class="p-3">Returned On</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($returned as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item->queue->queue_number }}</td>
                                <td class="p-3">{{ $item->client->first_name }} {{ $item->client->last_name }}</td>
                                <td class="p-3 text-sm text-gray-600">{{ $item->client->assessment?->approval_remarks }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $item->end_time?->format('M d, Y h:i A') }}</td>
                                <td class="p-3">
                                    <form method="POST" action="{{ route('social-worker.returned.resume', $item->id) }}">
                                        @csrf
                                        <x-primary-button type="submit">
                                            {{ __('Resume Assessment') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">{{ __('No returned applications.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $returned->links() }}
            </div>
        </div>
    </div>
</x-social-worker-layout>