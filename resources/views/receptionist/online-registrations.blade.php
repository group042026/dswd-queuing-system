<x-receptionist-layout>
    <style>
        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;
            --dswd-blue-light: rgba(0, 56, 168, 0.06);
            --dswd-red: #ce1126;
            --dswd-yellow: #fcd116;
            --emerald-green: #047857;
            --emerald-light: #ecfdf5;
            --emerald-border: #a7f3d0;
        }

        .category-badge {
            display: inline-block;
            padding: 4px 10px;
            border: 1px solid transparent;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .category-badge--seniorcitizens {
            color: #1d4ed8;
            background-color: #eff6ff;
            border-color: #bfdbfe;
        }

        .category-badge--familyheadsandotherneedyadult {
            color: #047857;
            background-color: #ecfdf5;
            border-color: #a7f3d0;
        }

        .category-badge--youthinneedandotherneedyadult {
            color: #7e22ce;
            background-color: #faf5ff;
            border-color: #e9d5ff;
        }

        .category-badge--youthinneedofspecialprotection {
            color: #b91c1c;
            background-color: #fef2f2;
            border-color: #fecaca;
        }

        .category-badge--men-womeninspeciallydifficultcircumstances {
            color: #c2410c;
            background-color: #fff7ed;
            border-color: #fed7aa;
        }

        .online-container {
            padding: 12px 0;
            color: #0f172a;
        }

        .online-banner {
            margin-bottom: 24px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .online-banner__content {
            padding: 28px 24px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
        }

        .online-banner__badge {
            margin-bottom: 6px;
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .online-banner__title {
            margin: 0 0 8px;
            font-size: 24px;
            font-weight: 800;
        }

        .online-banner__description {
            max-width: 650px;
            margin: 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            line-height: 1.5;
        }

        .online-banner__ribbon {
            display: flex;
            height: 4px;
        }

        .online-banner__stripe { width: 33.333%; }
        .online-banner__stripe--blue { background: var(--dswd-blue); }
        .online-banner__stripe--yellow { background: var(--dswd-yellow); }
        .online-banner__stripe--red { background: var(--dswd-red); }

        .online-card {
            margin-bottom: 24px;
            padding: 28px;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .online-table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
        }

        .online-table th {
            padding: 14px 16px;
            border-bottom: 2px solid #e2e8f0;
            color: #64748b;
            background: #f8fafc;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .online-table td {
            padding: 16px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
            font-size: 14px;
            vertical-align: middle;
        }

        .online-table tr:hover td { background: #f8fafc; }

        .online-container .btn-primary {
            background-color: #0038a8 !important;
            color: #ffffff !important;
            font-weight: 800 !important;
            border: none !important;
            border-radius: 8px !important;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .online-container .btn-primary:hover {
            background-color: #002878 !important;
        }

        .online-container .btn-primary:focus {
            background-color: #0038a8 !important;
            box-shadow: 0 0 0 3px rgba(0, 56, 168, 0.2) !important;
        }

        .queue-badge {
            display: inline-flex;
            min-width: 54px;
            justify-content: center;
            padding: 6px 10px;
            border-radius: 8px;
            color: var(--dswd-blue);
            background: var(--dswd-blue-light);
            font-family: monospace;
            font-size: 18px;
            font-weight: 800;
        }

        .priority-badge,
        .regular-badge {
            display: block;
            margin-top: 5px;
            font-size: 11px;
            font-weight: 800;
        }

        .priority-badge { color: #b91c1c; }
        .regular-badge { color: #64748b; }

        .document-badge {
            display: inline-flex;
            padding: 4px 10px;
            border: 1px solid var(--emerald-border);
            border-radius: 6px;
            color: var(--emerald-green);
            background: var(--emerald-light);
            font-size: 11px;
            font-weight: 800;
        }

        .document-badge--pending {
            border-color: #fde68a;
            color: #b45309;
            background: #fffbeb;
        }

        .modal-heading {
            padding: 20px 24px;
            color: #ffffff;
            background: linear-gradient(135deg, var(--dswd-blue), #1e40af);
        }

        .modal-heading h2 {
            margin: 0;
            font-size: 18px;
            font-weight: 800;
        }

        .modal-body { padding: 24px; }

        .modal-summary {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px;
            margin-bottom: 20px;
            padding: 16px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #f8fafc;
        }

        .modal-summary dt {
            margin-bottom: 4px;
            color: #94a3b8;
            font-size: 10px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .modal-summary dd {
            margin: 0;
            color: #334155;
            font-size: 13px;
            font-weight: 700;
        }

        .modal-notice {
            margin-bottom: 20px;
            padding: 12px 14px;
            border: 1px solid #bfdbfe;
            border-radius: 9px;
            color: #1e3a8a;
            background: #eff6ff;
            font-size: 13px;
            line-height: 1.5;
        }

        .modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #e2e8f0;
            padding-top: 18px;
        }

        @media (max-width: 640px) {
            .online-card { padding: 16px; }
            .online-banner__content { padding: 22px 18px; }
            .online-table { min-width: 850px; }
            .modal-summary { grid-template-columns: 1fr; }
        }
    </style>

    <div class="online-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="online-banner">
                <div class="online-banner__content">
                    <div class="online-banner__badge">DSWD Receptionist Portal</div>
                    <h1 class="online-banner__title">Online Pre-Registrations</h1>
                    <p class="online-banner__description">
                        Review online applications and confirm clients who have physically arrived at the DSWD office before sending them to document validation.
                    </p>
                </div>
                <div class="online-banner__ribbon">
                    <div class="online-banner__stripe online-banner__stripe--blue"></div>
                    <div class="online-banner__stripe online-banner__stripe--yellow"></div>
                    <div class="online-banner__stripe online-banner__stripe--red"></div>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-6 flex items-center gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
                    {{ $errors->first() }}
                </div>
            @endif

            <div class="online-card">
                <div class="mb-6 flex items-center justify-between gap-4 border-b pb-4">
                    <div>
                        <h2 class="text-lg font-extrabold text-gray-800">Pending Online Arrivals</h2>
                        <p class="mt-1 text-xs text-gray-500">Confirm arrival only after checking the client&apos;s control number and original valid ID.</p>
                    </div>
                    <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                        {{ $onlineRegistrations->total() }} Pending
                    </span>
                </div>
                <div class="overflow-x-auto">
                    <table class="online-table">
                        <thead class="bg-gray-50">
                            <tr>
                                <th>Queue #</th>
                                <th>Client Name</th>
                                <th>Category</th>
                                <th>Documents</th>
                                <th>Registered</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($onlineRegistrations as $queue)
                                <tr>
                                    <td>
                                        <span class="queue-badge">{{ $queue->queue_number }}</span>
                                        @if($queue->priority)
                                            <span class="priority-badge">Priority</span>
                                        @else
                                            <span class="regular-badge">Regular</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="font-extrabold text-gray-800">{{ $queue->client->first_name }} {{ $queue->client->last_name }}</div>
                                        <div class="mt-1 font-mono text-xs text-gray-400">{{ $queue->client->control_number }}</div>
                                        <div class="text-xs text-gray-500">{{ $queue->client->contact_number }}</div>
                                    </td>

                                    <td>
                                        <span class="category-badge category-badge--{{ strtolower(str_replace([' ', '/'], ['', '-'], $queue->client->client_category)) }}">
                                            {{ $queue->client->client_category }}
                                        </span>
                                    </td>

                                    <td>
                                        @php
                                            $totalDocuments = $queue->client->documents->count();
                                            $verifiedDocuments = $queue->client->documents->where('verified', true)->count();
                                        @endphp
                                        <span class="document-badge {{ $verifiedDocuments !== $totalDocuments ? 'document-badge--pending' : '' }}">
                                            {{ $verifiedDocuments }}/{{ $totalDocuments }} Verified
                                        </span>
                                    </td>

                                    <td class="whitespace-nowrap text-xs text-gray-500">
                                        {{ $queue->date_issued?->format('M d, Y h:i A') }}
                                    </td>

                                    <td>
                                        <x-primary-button
                                            type="button"
                                            class="btn-primary"
                                            x-on:click="$dispatch('open-modal', 'confirm-arrival-{{ $queue->id }}')"
                                        >
                                            {{ __('Confirm Arrival') }}
                                        </x-primary-button>
                                    </td>
                                </tr>

                                <x-modal name="confirm-arrival-{{ $queue->id }}" maxWidth="lg">
                                    <div class="modal-heading">
                                        <h2>{{ __('Confirm Client Arrival') }}</h2>
                                        <p class="mt-1 text-xs text-blue-100">Review the registration before adding the client to document validation.</p>
                                    </div>

                                    <div class="modal-body">
                                        <dl class="modal-summary">
                                            <div>
                                                <dt>Client Name</dt>
                                                <dd>{{ $queue->client->first_name }} {{ $queue->client->last_name }}</dd>
                                            </div>
                                            <div>
                                                <dt>Queue Number</dt>
                                                <dd class="font-mono text-blue-700">{{ $queue->queue_number }}</dd>
                                            </div>
                                            <div>
                                                <dt>Control Number</dt>
                                                <dd class="font-mono">{{ $queue->client->control_number }}</dd>
                                            </div>
                                            <div>
                                                <dt>Valid ID</dt>
                                                <dd>{{ $queue->client->valid_id_type }}</dd>
                                            </div>
                                            <div>
                                                <dt>Category</dt>
                                                <dd>{{ $queue->client->client_category }}</dd>
                                            </div>
                                            <div>
                                                <dt>Documents</dt>
                                                <dd>{{ $totalDocuments }} uploaded, {{ $verifiedDocuments }} verified</dd>
                                            </div>
                                        </dl>

                                        <div class="modal-notice">
                                            Confirm this only when the client is physically present and has shown the original valid ID. The queue will move to <strong>Serving</strong> and the client will enter document validation.
                                        </div>

                                        <form method="POST" action="{{ route('receptionist.online-registrations.confirm', $queue) }}">
                                            @csrf
                                            <div class="modal-actions">
                                                <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'confirm-arrival-{{ $queue->id }}')">
                                                    {{ __('Cancel') }}
                                                </x-secondary-button>
                                                <x-primary-button type="submit" class="btn-primary">
                                                    {{ __('Confirm and Proceed to Validation') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @empty
                                <tr>
                                    <td colspan="6" class="p-10 text-center text-gray-500">
                                        <div class="font-semibold">No pending online registrations.</div>
                                        <div class="mt-1 text-xs">New online applicants will appear here.</div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-6">
                    {{ $onlineRegistrations->links() }}
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.Echo.channel('receptionist-dashboard')
            .listen('.dashboard.updated', () => {
                window.location.reload();
            });
    });
</script>
@endpush
</x-receptionist-layout>