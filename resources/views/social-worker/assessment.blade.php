<x-social-worker-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Interview and Assessment') }}
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
                <form method="GET" action="{{ route('social-worker.assessment') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block"
                            value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit">
                        {{ __('Filter') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('social-worker.assessment') }}">
                            <x-secondary-button type="button">
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    {{ __('Showing pending assessment for:') }}
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </span>
                </div>

                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Pending Assessment') }}</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue #</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Program</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingAssessment as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item->queue->queue_number }}</td>
                                <td class="p-3">{{ $item->client->first_name }} {{ $item->client->last_name }}</td>
                                <td class="p-3">{{ $item->client->client_category }}</td>
                                <td class="p-3">{{ $item->client->program_requested }}</td>
                                <td class="p-3">
                                    <x-primary-button x-on:click="$dispatch('open-modal', 'assess-modal-{{ $item->id }}')">
                                        {{ __('Assess') }}
                                    </x-primary-button>
                                </td>
                            </tr>

                            <x-modal name="assess-modal-{{ $item->id }}" maxWidth="lg" :show="session('reopen_processing_id') == $item->id || $errors->any()">
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                                        {{ __('Assessment Form') }} — {{ $item->client->first_name }} {{ $item->client->last_name }}
                                    </h2>

                                    <div class="mb-4 text-sm text-gray-600">
                                        <p>{{ __('Category') }}: <strong>{{ $item->client->client_category }}</strong></p>
                                        <p>{{ __('Program') }}: <strong>{{ $item->client->program_requested }}</strong></p>
                                        <p>{{ __('Reason for Assistance') }}: <strong>{{ $item->client->reason_for_assistance }}</strong></p>
                                    </div>

                                    <form method="POST" action="{{ route('social-worker.assessment.store', $item->id) }}">
                                        @csrf

                                        <div class="mb-4">
                                            <x-input-label for="interview_date_{{ $item->id }}" :value="__('Interview Date')" />
                                            <x-text-input id="interview_date_{{ $item->id }}" name="interview_date" type="date" class="mt-1 block w-full" value="{{ old('interview_date', now()->format('Y-m-d')) }}" required />
                                            <x-input-error :messages="$errors->get('interview_date')" class="mt-2" />
                                        </div>

                                        <div class="mb-4">
                                            <x-input-label for="means_verification_{{ $item->id }}" :value="__('Means Verification')" />
                                            <textarea id="means_verification_{{ $item->id }}" name="means_verification" rows="2"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('means_verification') }}</textarea>
                                            <x-input-error :messages="$errors->get('means_verification')" class="mt-2" />
                                        </div>

                                        <div class="mb-4">
                                            <x-input-label for="assessment_findings_{{ $item->id }}" :value="__('Assessment Findings')" />
                                            <textarea id="assessment_findings_{{ $item->id }}" name="assessment_findings" rows="3"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('assessment_findings') }}</textarea>
                                            <x-input-error :messages="$errors->get('assessment_findings')" class="mt-2" />
                                        </div>

                                        <div class="mb-4">
                                            <x-input-label for="recommendation_{{ $item->id }}" :value="__('Recommendation')" />
                                            <textarea id="recommendation_{{ $item->id }}" name="recommendation" rows="3"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>{{ old('recommendation') }}</textarea>
                                            <x-input-error :messages="$errors->get('recommendation')" class="mt-2" />
                                        </div>

                                        <div class="mb-4">
                                            <x-input-label for="remarks_{{ $item->id }}" :value="__('Remarks (Optional)')" />
                                            <textarea id="remarks_{{ $item->id }}" name="remarks" rows="2"
                                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('remarks') }}</textarea>
                                        </div>

                                        <div class="flex justify-end gap-3 mt-6">
                                            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'assess-modal-{{ $item->id }}')">
                                                {{ __('Close') }}
                                            </x-secondary-button>
                                            <x-primary-button type="submit">
                                                {{ __('Complete Assessment') }}
                                            </x-primary-button>
                                        </div>
                                    </form>
                                </div>
                            </x-modal>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">{{ __('No clients pending assessment.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pendingAssessment->links() }}
            </div>
        </div>
    </div>
</x-social-worker-layout>