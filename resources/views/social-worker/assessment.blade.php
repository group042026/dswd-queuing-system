<x-social-worker-layout>
    <style>
        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;
            --dswd-blue-light: rgba(0, 56, 168, 0.06);
            --dswd-blue-border: rgba(0, 56, 168, 0.12);

            --dswd-red: #ce1126;
            --dswd-red-hover: #b00e1f;
            --dswd-red-light: rgba(206, 17, 38, 0.06);
            --dswd-red-border: rgba(206, 17, 38, 0.12);

            --dswd-yellow: #fcd116;
            --dswd-yellow-hover: #e0b800;
            --dswd-yellow-light: rgba(252, 209, 22, 0.12);

            --emerald-green: #047857;
            --emerald-light: #ecfdf5;
            --emerald-border: #a7f3d0;

            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;

            --transition-smooth: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .assessment-container {
            padding: 12px 0;
            color: var(--text-primary);
        }

        /* Banner */
        .assess-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .assess-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .assess-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .assess-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .assess-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .assess-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .assess-banner__stripe {
            height: 100%;
            width: 33.333%;
        }
        .assess-banner__stripe--blue { background-color: var(--dswd-blue); }
        .assess-banner__stripe--yellow { background-color: var(--dswd-yellow); }
        .assess-banner__stripe--red { background-color: var(--dswd-red); }

        /* Filter Section */
        .filter-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        /* Main Data Card */
        .data-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        /* Table Design */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .custom-table th {
            padding: 14px 16px;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            background-color: #f8fafc;
            border-bottom: 2px solid #e2e8f0;
        }

        .custom-table td {
            padding: 16px;
            font-size: 14px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            vertical-align: middle;
        }

        .custom-table tr:hover td {
            background-color: #f8fafc;
        }

        /* Category Badge */
        .category-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            display: inline-block;
        }

        .category-badge--senior { color: var(--dswd-blue); background-color: var(--dswd-blue-light); }
        .category-badge--pwd { color: var(--dswd-red); background-color: var(--dswd-red-light); }
        .category-badge--soloparent { color: #854d0e; background-color: var(--dswd-yellow-light); }
        .category-badge--regular { color: #475569; background-color: #e2e8f0; }

        /* Form Controls */
        .max-w-6xl input[type="date"],
        .max-w-6xl select,
        .max-w-6xl textarea {
            width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 14px;
            background-color: #ffffff;
            transition: all 0.2s ease-in-out;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            color: var(--text-primary);
        }

        .max-w-6xl input[type="date"]:focus,
        .max-w-6xl select:focus,
        .max-w-6xl textarea:focus {
            outline: none !important;
            border-color: var(--dswd-blue) !important;
            box-shadow: 0 0 0 3px var(--dswd-blue-light) !important;
        }

        /* Buttons overrides */
        .btn-primary {
            background-color: var(--dswd-blue) !important;
            color: var(--text-white) !important;
            font-weight: 800 !important;
            border-radius: 8px !important;
            transition: var(--transition-smooth) !important;
            border: none !important;
            cursor: pointer;
        }

        .btn-primary:hover {
            background-color: var(--dswd-blue-hover) !important;
        }
    </style>

    <div class="assessment-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Banner -->
            <div class="assess-banner">
                <div class="assess-banner__content">
                    <div class="assess-banner__badge">DSWD Social Worker Portal</div>
                    <h1 class="assess-banner__title">Interview and Assessment</h1>
                    <p class="assess-banner__description">
                        Conduct client evaluations, log verification mechanisms, specify assessment findings, and formulate program recommendations.
                    </p>
                </div>
                <div class="assess-banner__ribbon">
                    <div class="assess-banner__stripe assess-banner__stripe--blue"></div>
                    <div class="assess-banner__stripe assess-banner__stripe--yellow"></div>
                    <div class="assess-banner__stripe assess-banner__stripe--red"></div>
                </div>
            </div>

            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            {{-- Date filter --}}
            <div class="filter-card">
                <form method="GET" action="{{ route('social-worker.assessment') }}" class="flex items-end gap-3 flex-wrap">
                    <div class="flex flex-col gap-1.5">
                        <x-input-label for="date" :value="__('Select Queue Date')" class="font-semibold text-gray-700 text-xs" />
                        <x-text-input id="date" name="date" type="date" class="block" value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit" class="h-[42px] px-5 btn-primary">
                        {{ __('Filter Queue') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('social-worker.assessment') }}">
                            <x-secondary-button type="button" class="h-[42px] px-5">
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>

            <div class="data-card">
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">{{ __('Pending Assessment List') }}</h3>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ __('Showing pending assessment for:') }}
                            <span class="font-bold text-gray-700">
                                {{ \Carbon\Carbon::parse($selectedDate)->format('F d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="custom-table">
                        <thead>
                            <tr>
                                <th>Queue #</th>
                                <th>Client Name</th>
                                <th>Category</th>
                                <th>Program</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingAssessment as $item)
                                <tr>
                                    <td class="font-bold text-gray-900">{{ $item->queue->queue_number }}</td>
                                    <td>
                                        <div class="font-extrabold text-gray-800">{{ $item->client->first_name }} {{ $item->client->last_name }}</div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">{{ $item->client->control_number }}</div>
                                    </td>
                                    <td>
                                        <span class="category-badge category-badge--{{ strtolower(str_replace(' ', '', $item->client->client_category)) }}">
                                            {{ $item->client->client_category }}
                                        </span>
                                    </td>
                                    <td class="font-semibold text-gray-700">
                                        {{ $item->client->program_requested }}
                                    </td>
                                    <td>
                                        @php
                                            $isToday = $selectedDate === now()->format('Y-m-d');
                                        @endphp

                                        @if($isToday)
                                            <x-primary-button x-on:click="$dispatch('open-modal', 'assess-modal-{{ $item->id }}')" class="btn-primary">
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
                                        <div class="border-b pb-4 mb-4">
                                            <h2 class="text-lg font-extrabold text-gray-800">
                                                {{ __('Assessment Form') }}
                                            </h2>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Client: <span class="font-semibold text-gray-700">{{ $item->client->first_name }} {{ $item->client->last_name }}</span>
                                            </p>
                                        </div>

                                        <div class="mb-6 bg-slate-50 p-4 rounded-xl text-sm border border-slate-100 flex flex-col gap-3">
                                            <div class="grid grid-cols-2 gap-4">
                                                <div>
                                                    <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Category') }}</span>
                                                    <span class="font-semibold text-gray-700">{{ $item->client->client_category }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Program') }}</span>
                                                    <span class="font-semibold text-gray-700">{{ $item->client->program_requested }}</span>
                                                </div>
                                            </div>
                                            <div class="border-t pt-2.5">
                                                <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Reason for Assistance') }}</span>
                                                <span class="font-semibold text-gray-700 block mt-1 leading-normal">{{ $item->client->reason_for_assistance }}</span>
                                            </div>
                                        </div>

                                        {{-- Supporting Documents --}}
                                        <div class="mb-6 border-t pt-4">
                                            <h4 class="font-bold text-sm text-gray-800 mb-3">{{ __('Uploaded Checklist') }}</h4>

                                            <div class="flex flex-col gap-2 mb-4">
                                                @forelse($item->client->documents as $document)
                                                    <div class="flex justify-between items-center p-3 rounded-lg border border-slate-100 bg-white text-sm shadow-sm">
                                                        <div>
                                                            <span class="font-medium text-gray-700">{{ $document->document_name }}</span>
                                                            <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-600 text-xs ml-3 font-semibold hover:underline inline-flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                                                </svg>
                                                                {{ __('View File') }}
                                                            </a>
                                                        </div>

                                                        @if($document->verified)
                                                            <span class="text-green-600 text-xs font-bold inline-flex items-center gap-1">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                </svg>
                                                                {{ __('Verified') }}
                                                            </span>
                                                        @else
                                                            <form method="POST" action="{{ route('social-worker.documents.verify', $document->id) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="reopen_id" value="{{ $item->id }}">
                                                                <button type="submit" class="text-yellow-600 text-xs font-extrabold hover:underline">
                                                                    {{ __('Verify Doc') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <p class="text-sm text-gray-400 italic">{{ __('No documents uploaded yet.') }}</p>
                                                @endforelse
                                            </div>

                                            <form method="POST" action="{{ route('social-worker.documents.store') }}" enctype="multipart/form-data" class="mt-4 pt-4 border-t border-slate-100">
                                                @csrf
                                                <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                                <input type="hidden" name="reopen_id" value="{{ $item->id }}">

                                                <h4 class="font-bold text-xs text-slate-500 uppercase tracking-wider mb-3">{{ __('Add Supporting Documents') }}</h4>
                                                
                                                <div class="grid grid-cols-2 gap-3 mb-3">
                                                    <div class="flex flex-col gap-1">
                                                        <x-input-label for="doc_type_{{ $item->id }}" :value="__('Document Type')" class="text-xs font-bold" />
                                                        <select id="doc_type_{{ $item->id }}" name="document_name" required>
                                                            <option value="">-- {{ __('Select') }} --</option>
                                                            <option value="Medical Certificate">Medical Certificate</option>
                                                            <option value="School Enrollment Certificate">School Enrollment Certificate</option>
                                                            <option value="Birth Certificate">Birth Certificate</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                    </div>

                                                    <div class="flex flex-col gap-1">
                                                        <x-input-label for="doc_file_{{ $item->id }}" :value="__('File')" class="text-xs font-bold" />
                                                        <input type="file" id="doc_file_{{ $item->id }}" name="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 file:cursor-pointer hover:file:bg-slate-100" required>
                                                    </div>
                                                </div>

                                                <x-input-error :messages="$errors->get('file')" class="mt-2" />
                                                <x-input-error :messages="$errors->get('document_name')" class="mt-2" />

                                                <div class="flex justify-end mt-2">
                                                    <x-secondary-button type="submit" class="text-xs py-2 px-4">
                                                        {{ __('Upload Doc') }}
                                                    </x-secondary-button>
                                                </div>
                                            </form>
                                        </div>

                                        <form method="POST" action="{{ route('social-worker.assessment.store', $item->id) }}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-4">
                                                <x-input-label for="interview_date_{{ $item->id }}" :value="__('Interview Date')" class="font-bold text-gray-700" />
                                                <x-text-input id="interview_date_{{ $item->id }}" name="interview_date" type="date" class="mt-1.5 block w-full" value="{{ old('interview_date', now()->format('Y-m-d')) }}" required />
                                                <x-input-error :messages="$errors->get('interview_date')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <x-input-label for="means_verification_{{ $item->id }}" :value="__('Means Verification (Proof of Appearance Photo)')" />
                                                <input type="file" id="means_verification_{{ $item->id }}" name="means_verification"
                                                    accept=".jpg,.jpeg,.png" capture="environment"
                                                    class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100"
                                                    required>
                                                <x-input-error :messages="$errors->get('means_verification')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <x-input-label for="assessment_findings_{{ $item->id }}" :value="__('Assessment Findings')" class="font-bold text-gray-700" />
                                                <textarea id="assessment_findings_{{ $item->id }}" name="assessment_findings" rows="3" class="mt-1.5 block w-full" required>{{ old('assessment_findings') }}</textarea>
                                                <x-input-error :messages="$errors->get('assessment_findings')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <x-input-label for="recommendation_{{ $item->id }}" :value="__('Recommendation')" class="font-bold text-gray-700" />
                                                <textarea id="recommendation_{{ $item->id }}" name="recommendation" rows="3" class="mt-1.5 block w-full" required>{{ old('recommendation') }}</textarea>
                                                <x-input-error :messages="$errors->get('recommendation')" class="mt-2" />
                                            </div>

                                            <div class="mb-4">
                                                <x-input-label for="remarks_{{ $item->id }}" :value="__('Remarks (Optional)')" class="font-bold text-gray-700" />
                                                <textarea id="remarks_{{ $item->id }}" name="remarks" rows="2" class="mt-1.5 block w-full">{{ old('remarks') }}</textarea>
                                            </div>

                                            <div class="flex justify-end gap-3 mt-6 border-t pt-4">
                                                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'assess-modal-{{ $item->id }}')">
                                                    {{ __('Close') }}
                                                </x-secondary-button>
                                                <x-primary-button type="submit" class="btn-primary">
                                                    {{ __('Complete Assessment') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-8 text-center text-gray-500 italic">{{ __('No clients pending assessment.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pendingAssessment->links() }}
                </div>
            </div>
        </div>
    </div>
</x-social-worker-layout>