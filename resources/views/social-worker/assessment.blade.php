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
                                    @php
                                        $isToday = $selectedDate === now()->format('Y-m-d');
                                    @endphp

                                    @if($isToday)
                                        <x-primary-button x-on:click="$dispatch('open-modal', 'assess-modal-{{ $item->id }}')">
                                            {{ __('Assess') }}
                                        </x-primary-button>
                                    @else
                                        <x-secondary-button type="button" disabled class="opacity-50 cursor-not-allowed">
                                            {{ __('View Only') }}
                                        </x-secondary-button>
                                    @endif
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

                                    {{-- Supporting Documents section --}}
                                    <div class="mb-4 border-t pt-4">
                                        <h4 class="font-semibold text-sm mb-2">{{ __('Uploaded Valid ID') }}</h4>

                                        @forelse($item->client->documents as $document)
                                            <div class="flex justify-between items-center py-2 text-sm">
                                                <div>
                                                    <span>{{ $document->document_name }}</span>
                                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 text-xs ml-2 hover:underline">
                                                        {{ __('View File') }}
                                                    </a>
                                                </div>

                                                @if($document->verified)
                                                    <span class="text-green-600 text-xs font-semibold">✓ {{ __('Verified') }}</span>
                                                @else
                                                    <form method="POST" action="{{ route('social-worker.documents.verify', $document->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="reopen_id" value="{{ $item->id }}">
                                                        <button type="submit" class="text-yellow-600 text-xs font-semibold hover:underline">
                                                            {{ __('Mark as Verified') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 mb-3">{{ __('No documents uploaded yet.') }}</p>
                                        @endforelse

                                        <form method="POST" action="{{ route('social-worker.documents.store') }}" enctype="multipart/form-data" class="mt-4 pt-4 border-t">
                                            @csrf
                                            <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                            <input type="hidden" name="reopen_id" value="{{ $item->id }}">

                                            <div class="grid grid-cols-2 gap-3">

                                                <h4 class="font-semibold text-sm mb-2">{{ __('Supporting Documents') }}</h4>

                                                <div>
                                                    <x-input-label for="doc_type_{{ $item->id }}" :value="__('Document Type')" />
                                                    <select id="doc_type_{{ $item->id }}" name="document_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm text-sm" required>
                                                        <option value="">-- {{ __('Select') }} --</option>
                                                        <option value="Medical Certificate">Medical Certificate</option>
                                                        <option value="School Enrollment Certificate">School Enrollment Certificate</option>
                                                        <option value="Birth Certificate">Birth Certificate</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                </div>

                                                <div>
                                                    <x-input-label for="doc_file_{{ $item->id }}" :value="__('File')" />
                                                    <input type="file" id="doc_file_{{ $item->id }}" name="file" class="mt-1 block w-full text-sm" required>
                                                </div>
                                            </div>

                                            <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                            <x-input-error :messages="$errors->get('document_name')" class="mt-2" />

                                            <div class="flex justify-end mt-3">
                                                <x-secondary-button type="submit">
                                                    {{ __('Upload Document') }}
                                                </x-secondary-button>
                                            </div>
                                        </form>
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