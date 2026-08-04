<x-receptionist-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Validation and Encoding') }}
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
                <form method="GET" action="{{ route('receptionist.validation') }}" class="flex items-end gap-3">
                    <div>
                        <x-input-label for="date" :value="__('Select Date')" />
                        <x-text-input id="date" name="date" type="date" class="mt-1 block"
                            value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit">
                        {{ __('Filter') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('receptionist.validation') }}">
                            <x-secondary-button type="button">
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="mb-4 text-sm text-gray-500">
                    {{ __('Showing pending validation for:') }}
                    <span class="font-semibold text-gray-700">
                        {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                    </span>
                </div>
                
                <h3 class="text-lg font-semibold mb-4 pb-2 border-b">{{ __('Pending Validation') }}</h3>

                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b bg-gray-50">
                            <th class="p-3">Queue #</th>
                            <th class="p-3">Client Name</th>
                            <th class="p-3">Category</th>
                            <th class="p-3">Date Registered</th>
                            <th class="p-3">Documents</th>
                            <th class="p-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pendingValidation as $item)
                            <tr class="border-b">
                                <td class="p-3">{{ $item->queue->queue_number }}</td>
                                <td class="p-3">{{ $item->client->first_name }} {{ $item->client->last_name }}</td>
                                <td class="p-3">{{ $item->client->client_category }}</td>
                                <td class="p-3">{{ \Carbon\Carbon::parse($item->start_time)->format('M d, Y h:i A') }}</td>
                                <td class="p-3">
                                    @php
                                        $totalDocs = $item->client->documents->count();
                                        $verifiedDocs = $item->client->documents->where('verified', true)->count();
                                    @endphp

                                    @if($totalDocs === 0)
                                        <span class="text-gray-400 text-xs">{{ __('No documents') }}</span>
                                    @elseif($verifiedDocs === $totalDocs)
                                        <span class="text-green-600 text-xs font-semibold">✓ {{ $verifiedDocs }}/{{ $totalDocs }} {{ __('Verified') }}</span>
                                    @else
                                        <span class="text-yellow-600 text-xs font-semibold">{{ $verifiedDocs }}/{{ $totalDocs }} {{ __('Verified') }}</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    <x-primary-button x-on:click="$dispatch('open-modal', 'validate-modal-{{ $item->id }}')">
                                        {{ __('Validate') }}
                                    </x-primary-button>
                                </td>
                            </tr>

                            <x-modal name="validate-modal-{{ $item->id }}" maxWidth="lg" :show="session('reopen_client_id') == $item->client_id || $errors->any()">                                
                                <div class="p-6">
                                    <h2 class="text-lg font-medium text-gray-900 mb-4">
                                        {{ __('Validate Requirements') }} — {{ $item->client->first_name }} {{ $item->client->last_name }}
                                    </h2>

                                    <div class="mb-4">
                                        <p class="text-sm text-gray-600 mb-1">{{ __('Client Category') }}: <strong>{{ $item->client->client_category }}</strong></p>
                                        <p class="text-sm text-gray-600">{{ __('Program Requested') }}: <strong>{{ $item->client->program_requested }}</strong></p>
                                    </div>

                                    <div class="mb-4 border-t pt-4">
                                        <h4 class="font-semibold text-sm mb-2">{{ __('Submitted Documents') }}</h4>

                                        {{-- Listahan ng existing documents --}}
                                        @forelse($item->client->documents as $document)
                                            <div class="flex justify-between items-center py-2 border-b text-sm">
                                                <div>
                                                    <span>{{ $document->document_name }}</span>
                                                    <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 text-xs ml-2 hover:underline">
                                                        {{ __('View File') }}
                                                    </a>
                                                </div>

                                                @if($document->verified)
                                                    <span class="text-green-600 text-xs font-semibold">✓ {{ __('Verified') }}</span>
                                                @else
                                                    <form method="POST" action="{{ route('receptionist.documents.verify', $document->id) }}">
                                                        @csrf
                                                        @method('PATCH')
                                                        <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">
                                                        <button type="submit" class="text-yellow-600 text-xs font-semibold hover:underline">
                                                            {{ __('Mark as Verified') }}
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        @empty
                                            <p class="text-sm text-gray-400 mb-3">{{ __('No documents uploaded yet.') }}</p>
                                        @endforelse

                                        {{-- Upload section para sa Valid ID — HIWALAY, gamit ang totoong type mula Registration --}}
                                        <div class="mt-4 mb-3 p-3 bg-gray-50 rounded-lg">
                                            <p class="text-sm font-medium mb-2">
                                                {{ __('Upload scan of') }}: <strong>{{ $item->client->valid_id_type }}</strong>
                                                <span class="text-gray-500 text-xs">({{ __('ID No.') }}: {{ $item->client->valid_id_number }})</span>
                                            </p>

                                            <form method="POST" action="{{ route('receptionist.documents.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                                <input type="hidden" name="document_name" value="{{ $item->client->valid_id_type }}">
                                                <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">

                                                <div class="flex gap-2 items-center">
                                                    <input type="file" name="file" class="block w-full text-sm" required>
                                                    <x-secondary-button type="submit">{{ __('Upload') }}</x-secondary-button>
                                                </div>
                                            </form>
                                        </div>

                                        {{-- Upload section para sa IBANG requirements — dito lang manatili yung generic dropdown --}}
                                        <div class="mb-3 pt-3 border-t">
                                            <p class="text-sm font-medium mb-2">{{ __('Other Requirements') }}</p>
                                            <form method="POST" action="{{ route('receptionist.documents.store') }}" enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                                <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">

                                                <div class="grid grid-cols-2 gap-3">
                                                    <select name="document_name" class="border-gray-300 rounded-md text-sm" required>
                                                        <option value="">-- {{ __('Select') }} --</option>
                                                        <option value="Barangay Certificate">Barangay Certificate</option>
                                                        <option value="Income Certificate">Income Certificate</option>
                                                        <option value="Other">Other</option>
                                                    </select>
                                                    <input type="file" name="file" class="text-sm" required>
                                                </div>
                                                <x-secondary-button type="submit" class="mt-2">{{ __('Upload') }}</x-secondary-button>
                                            </form>
                                        </div>
                                    </div>

                                    @php
                                        $totalDocs = $item->client->documents->count();
                                        $verifiedDocs = $item->client->documents->where('verified', true)->count();
                                        $canProceed = $totalDocs > 0 && $verifiedDocs === $totalDocs;
                                    @endphp

                                    <form method="POST" action="{{ route('receptionist.validation.proceed', $item->id) }}">
                                        @csrf
                                        <div class="flex justify-end gap-3 mt-6">
                                            <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'validate-modal-{{ $item->id }}')">
                                                {{ __('Close') }}
                                            </x-secondary-button>

                                            @if($canProceed)
                                                <x-primary-button type="submit">
                                                    {{ __('Proceed to Assessment') }}
                                                </x-primary-button>
                                            @else
                                                <x-primary-button type="submit" disabled class="opacity-50 cursor-not-allowed">
                                                    {{ __('Proceed to Assessment') }}
                                                </x-primary-button>
                                            @endif
                                        </div>

                                        @if(!$canProceed)
                                            <p class="text-xs text-gray-500 mt-2 text-right">
                                                @if($totalDocs === 0)
                                                    {{ __('Please upload requirements.') }}
                                                @else
                                                    {{ __('Please verify documents first.') }}
                                                @endif
                                            </p>
                                        @endif
                                    </form>
                                </div>
                            </x-modal>
                        @empty
                            <tr>
                                <td colspan="5" class="p-3 text-center text-gray-500">{{ __('No clients pending validation.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                {{ $pendingValidation->links() }}
            </div>
        </div>
    </div>
</x-receptionist-layout>