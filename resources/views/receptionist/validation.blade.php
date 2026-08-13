<x-receptionist-layout>
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

        .validation-container {
            padding: 12px 0;
            color: var(--text-primary);
        }

        /* Banner */
        .val-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .val-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .val-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .val-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .val-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .val-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .val-banner__stripe {
            height: 100%;
            width: 33.333%;
        }
        .val-banner__stripe--blue { background-color: var(--dswd-blue); }
        .val-banner__stripe--yellow { background-color: var(--dswd-yellow); }
        .val-banner__stripe--red { background-color: var(--dswd-red); }

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

        /* Doc Status Badge */
        .doc-badge {
            font-size: 11px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            text-transform: uppercase;
            letter-spacing: 0.02em;
        }
        .doc-badge--verified { color: var(--emerald-green); background-color: var(--emerald-light); border: 1px solid var(--emerald-border); }
        .doc-badge--pending { color: #b45309; background-color: var(--dswd-yellow-light); border: 1px solid rgba(252, 209, 22, 0.3); }
        .doc-badge--none { color: var(--text-muted); background-color: #f1f5f9; }

        /* Form Controls */
        .max-w-6xl input[type="date"],
        .max-w-6xl select {
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
        .max-w-6xl select:focus {
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

    <div class="validation-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Banner -->
            <div class="val-banner">
                <div class="val-banner__content">
                    <div class="val-banner__badge">DSWD Receptionist Portal</div>
                    <h1 class="val-banner__title">Validation and Encoding</h1>
                    <p class="val-banner__description">
                        Verify physically submitted files against program requirements, scan and store identification cards, and approve cases to advance to Social Worker Assessment.
                    </p>
                </div>
                <div class="val-banner__ribbon">
                    <div class="val-banner__stripe val-banner__stripe--blue"></div>
                    <div class="val-banner__stripe val-banner__stripe--yellow"></div>
                    <div class="val-banner__stripe val-banner__stripe--red"></div>
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
                <form method="GET" action="{{ route('receptionist.validation') }}" class="flex items-end gap-3 flex-wrap">
                    <div class="flex flex-col gap-1.5">
                        <x-input-label for="date" :value="__('Select Queue Date')" class="font-semibold text-gray-700 text-xs" />
                        <x-text-input id="date" name="date" type="date" class="block" value="{{ $selectedDate }}" />
                    </div>

                    <x-primary-button type="submit" class="h-[42px] px-5 btn-primary">
                        {{ __('Filter Queue') }}
                    </x-primary-button>

                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('receptionist.validation') }}">
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
                        <h3 class="text-lg font-extrabold text-gray-800">{{ __('Pending Validation List') }}</h3>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ __('Showing pending validation for:') }}
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
                                <th>Date Registered</th>
                                <th>Documents</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pendingValidation as $item)
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
                                    <td class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($item->start_time)->format('M d, Y h:i A') }}
                                    </td>
                                    <td>
                                        @php
                                            $totalDocs = $item->client->documents->count();
                                            $verifiedDocs = $item->client->documents->where('verified', true)->count();
                                        @endphp

                                        @if($totalDocs === 0)
                                            <span class="doc-badge doc-badge--none">{{ __('No documents') }}</span>
                                        @elseif($verifiedDocs === $totalDocs)
                                            <span class="doc-badge doc-badge--verified">✓ {{ $verifiedDocs }}/{{ $totalDocs }} {{ __('Verified') }}</span>
                                        @else
                                            <span class="doc-badge doc-badge--pending">{{ $verifiedDocs }}/{{ $totalDocs }} {{ __('Verified') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $isToday = $selectedDate === now()->format('Y-m-d');
                                        @endphp

                                        @if($isToday)
                                            <x-primary-button x-on:click="$dispatch('open-modal', 'validate-modal-{{ $item->id }}')" class="btn-primary">
                                                {{ __('Validate') }}
                                            </x-primary-button>
                                        @else
                                            <x-secondary-button type="button" disabled class="opacity-50 cursor-not-allowed">
                                                {{ __('View Only') }}
                                            </x-secondary-button>
                                        @endif
                                    </td>
                                </tr>

                                <x-modal name="validate-modal-{{ $item->id }}" maxWidth="lg" :show="session('reopen_client_id') == $item->client_id || $errors->any()">
                                    <div class="p-6">
                                        <div class="border-b pb-4 mb-4">
                                            <h2 class="text-lg font-extrabold text-gray-800">
                                                {{ __('Validate Requirements') }}
                                            </h2>
                                            <p class="text-sm text-gray-500 mt-1">
                                                Client: <span class="font-semibold text-gray-700">{{ $item->client->first_name }} {{ $item->client->last_name }}</span>
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4 mb-6 bg-slate-50 p-4 rounded-xl text-sm border border-slate-100">
                                            <div>
                                                <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Client Category') }}</span>
                                                <span class="font-semibold text-gray-700">{{ $item->client->client_category }}</span>
                                            </div>
                                            <div>
                                                <span class="text-xs text-gray-400 block uppercase font-bold">{{ __('Program Requested') }}</span>
                                                <span class="font-semibold text-gray-700">{{ $item->client->program_requested }}</span>
                                            </div>
                                        </div>

                                        <div class="mb-6">
                                            <h4 class="font-bold text-sm text-gray-800 mb-3">{{ __('Submitted Checklist') }}</h4>

                                            {{-- List of documents --}}
                                            <div class="flex flex-col gap-2.5 mb-4">
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
                                                            <form method="POST" action="{{ route('receptionist.documents.verify', $document->id) }}">
                                                                @csrf
                                                                @method('PATCH')
                                                                <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">
                                                                <button type="submit" class="text-yellow-600 text-xs font-extrabold hover:underline">
                                                                    {{ __('Verify File') }}
                                                                </button>
                                                            </form>
                                                        @endif
                                                    </div>
                                                @empty
                                                    <p class="text-sm text-gray-400 italic">{{ __('No documents uploaded yet.') }}</p>
                                                @endforelse
                                            </div>

                                            {{-- Upload primary ID --}}
                                            <div class="mt-4 mb-4 p-4 bg-blue-50/50 rounded-xl border border-blue-100">
                                                <p class="text-xs font-bold text-blue-900 mb-2 uppercase tracking-wide">
                                                    {{ __('Upload Required ID') }}: <span class="text-gray-700 font-semibold">{{ $item->client->valid_id_type }}</span>
                                                    <span class="text-gray-500 text-xs lowercase">({{ __('ID No.') }}: {{ $item->client->valid_id_number }})</span>
                                                </p>

                                                <form method="POST" action="{{ route('receptionist.documents.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                                    <input type="hidden" name="document_name" value="{{ $item->client->valid_id_type }}">
                                                    <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">

                                                    <div class="flex gap-3 items-center">
                                                        <input type="file" name="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-blue-50 file:text-blue-700 file:cursor-pointer hover:file:bg-blue-100" required>
                                                        <x-secondary-button type="submit" class="text-xs py-2 px-4">{{ __('Upload') }}</x-secondary-button>
                                                    </div>
                                                </form>
                                            </div>

                                            {{-- Upload other docs --}}
                                            <div class="mb-4 pt-4 border-t border-slate-100">
                                                <p class="text-xs font-bold text-gray-700 mb-2 uppercase tracking-wide">{{ __('Upload Other Requirements') }}</p>
                                                <form method="POST" action="{{ route('receptionist.documents.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <input type="hidden" name="client_id" value="{{ $item->client_id }}">
                                                    <input type="hidden" name="reopen_id" value="{{ $item->client_id }}">

                                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                                        <select name="document_name" required>
                                                            <option value="">-- {{ __('Select') }} --</option>
                                                            <option value="Barangay Certificate">Barangay Certificate</option>
                                                            <option value="Income Certificate">Income Certificate</option>
                                                            <option value="Other">Other</option>
                                                        </select>
                                                        <input type="file" name="file" class="block w-full text-xs text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-slate-50 file:text-slate-700 file:cursor-pointer hover:file:bg-slate-100" required>
                                                    </div>
                                                    <x-secondary-button type="submit" class="text-xs py-2 px-4">{{ __('Upload Extra Document') }}</x-secondary-button>
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
                                            <div class="flex justify-end gap-3 mt-6 border-t pt-4">
                                                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'validate-modal-{{ $item->id }}')">
                                                    {{ __('Close') }}
                                                </x-secondary-button>

                                                @if($canProceed)
                                                    <x-primary-button type="submit" class="btn-primary">
                                                        {{ __('Proceed to Assessment') }}
                                                    </x-primary-button>
                                                @else
                                                    <x-primary-button type="submit" disabled class="opacity-50 cursor-not-allowed">
                                                        {{ __('Proceed to Assessment') }}
                                                    </x-primary-button>
                                                @endif
                                            </div>

                                            @if(!$canProceed)
                                                <p class="text-xs text-red-500 mt-2 text-right font-semibold">
                                                    @if($totalDocs === 0)
                                                        {{ __('Please upload requirements first.') }}
                                                    @else
                                                        {{ __('Please verify all documents first.') }}
                                                    @endif
                                                </p>
                                            @endif
                                        </form>
                                    </div>
                                </x-modal>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-8 text-center text-gray-500 italic">{{ __('No clients pending validation.') }}</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $pendingValidation->links() }}
                </div>
            </div>
        </div>
    </div>
</x-receptionist-layout>