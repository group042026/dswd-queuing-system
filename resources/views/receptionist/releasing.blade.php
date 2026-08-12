<x-receptionist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Releasing Management') }}
        </h2>
    </x-slot>

    <div class="py-6" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Date filter --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-4 mb-4">
                <form method="GET" action="{{ route('receptionist.releasing') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block" value="{{ $selectedDate }}" />
                    </div>
                    <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('receptionist.releasing') }}">
                            <x-secondary-button type="button">{{ __('Back to Today') }}</x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Pending Releasing') }}</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue #</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Program</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $isToday = $selectedDate === now()->format('Y-m-d'); @endphp

                        @forelse($pendingReleasing as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item->queue->queue_number }}</td>
                                <td class="p-3">{{ $item->client->first_name }} {{ $item->client->last_name }}</td>
                                <td class="p-3">{{ $item->client->program_requested }}</td>
                                <td class="p-3">
                                    @if($isToday)
                                        <x-primary-button x-on:click="$dispatch('open-modal', 'release-modal-{{ $item->id }}')">
                                            {{ __('Release') }}
                                        </x-primary-button>
                                    @else
                                        <x-secondary-button type="button" disabled class="opacity-50 cursor-not-allowed">
                                            {{ __('View Only') }}
                                        </x-secondary-button>
                                    @endif
                                </td>
                            </tr>

                            @if($isToday)
                                <x-modal name="release-modal-{{ $item->id }}" maxWidth="lg">
                                    <div class="p-6">
                                        <h2 class="text-lg font-medium text-gray-900 mb-4">
                                            {{ __('Release Assistance') }} — {{ $item->client->first_name }} {{ $item->client->last_name }}
                                        </h2>

                                        <div class="mb-4 text-sm text-gray-600">
                                            <p>{{ __('Program') }}: <strong>{{ $item->client->program_requested }}</strong></p>
                                            <p>{{ __('Category') }}: <strong>{{ $item->client->client_category }}</strong></p>
                                        </div>

                                        <form method="POST" action="{{ route('receptionist.releasing.release', $item->id) }}">
                                            @csrf

                                            <div class="mb-4">
                                                <x-input-label for="remarks_{{ $item->id }}" :value="__('Remarks (Optional)')" />
                                                <textarea id="remarks_{{ $item->id }}" name="remarks" rows="3"
                                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm"
                                                    placeholder="{{ __('e.g. Released to client personally, claimed by representative, etc.') }}">{{ old('remarks') }}</textarea>
                                            </div>

                                            <div class="flex justify-end gap-3 mt-6">
                                                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'release-modal-{{ $item->id }}')">
                                                    {{ __('Close') }}
                                                </x-secondary-button>
                                                <x-primary-button type="submit">
                                                    {{ __('Confirm Release') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @endif
                        @empty
                            <tr>
                                <td colspan="4" class="p-3 text-center text-gray-500">{{ __('No clients pending releasing.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pendingReleasing->links() }}
            </div>
        </div>
    </div>
</x-receptionist-layout>