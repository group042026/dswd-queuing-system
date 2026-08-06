<x-approving-officer-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Review and Approval') }}
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
                <form method="GET" action="{{ route('approving-officer.review') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block" value="{{ $selectedDate }}" />
                    </div>
                    <x-primary-button type="submit">{{ __('Filter') }}</x-primary-button>
                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('approving-officer.review') }}">
                            <x-secondary-button type="button">{{ __('Back to Today') }}</x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Pending Review') }}</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue #</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Social Worker</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $isToday = $selectedDate === now()->format('Y-m-d'); @endphp

                        @forelse($pendingReview as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item->queue->queue_number }}</td>
                                <td class="p-3">{{ $item->client->first_name }} {{ $item->client->last_name }}</td>
                                <td class="p-3">{{ $item->client->client_category }}</td>
                                <td class="p-3">{{ $item->client->assessment?->socialWorker?->first_name }}</td>
                                <td class="p-3">
                                    @if($isToday)
                                        <x-primary-button x-on:click="$dispatch('open-modal', 'review-modal-{{ $item->id }}')">
                                            {{ __('Review') }}
                                        </x-primary-button>
                                    @else
                                        <x-secondary-button type="button" disabled class="opacity-50 cursor-not-allowed">
                                            {{ __('View Only') }}
                                        </x-secondary-button>
                                    @endif
                                </td>
                            </tr>

                            <x-modal name="review-modal-{{ $item->id }}" maxWidth="2xl" :show="$errors->any()">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                                        {{ __('Review Application') }} — {{ $item->client->first_name }} {{ $item->client->last_name }}
                                    </h2>

                                    @php $assessment = $item->client->assessment; @endphp

                                    <div class="mb-4 text-sm text-gray-600 space-y-1 border-b pb-4">
                                        <p>{{ __('Interview Date') }}: <strong>{{ \Carbon\Carbon::parse($assessment->interview_date)->format('M d, Y') }}</strong></p>
                                        <p>{{ __('Means Verification') }}: {{ $assessment->means_verification }}</p>
                                        <p>{{ __('Findings') }}: {{ $assessment->assessment_findings }}</p>
                                        <p>{{ __('Recommendation') }}: {{ $assessment->recommendation }}</p>
                                        @if($assessment->remarks)
                                            <p>{{ __('Remarks') }}: {{ $assessment->remarks }}</p>
                                        @endif
                                    </div>

                                    <form method="POST" action="{{ route('approving-officer.review.decide', $item->id) }}">
                                        @csrf

                                        <div class="mb-4">
                                            <x-input-label for="approval_remarks_{{ $item->id }}" :value="__('Approval Remarks')" />
                                            <textarea id="approval_remarks_{{ $item->id }}" name="approval_remarks" rows="3"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('approval_remarks') }}</textarea>
                                            <x-input-error :messages="$errors->get('approval_remarks')" class="mt-2" />
                                        </div>

                                        <div class="flex justify-end gap-3 mt-6">
                                            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'review-modal-{{ $item->id }}')">
                                                {{ __('Close') }}
                                            </x-secondary-button>
                                            <x-danger-button type="submit" name="decision" value="Returned">
                                                {{ __('Return') }}
                                            </x-danger-button>
                                            <x-primary-button type="submit" name="decision" value="Approved">
                                                {{ __('Approve') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">{{ __('No applications pending review.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pendingReview->links() }}
            </div>
        </div>
    </div>
</x-approving-officer-layout>