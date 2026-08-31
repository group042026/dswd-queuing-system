<x-approving-officer-layout>
    <style>
        /* ============================================================
           1. Core Variables & Theme
           ============================================================ */
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

        /* ============================================================
           2. Dark Mode
           ============================================================ */
        .dark {
            --bg-gray: #0f172a;
            --card-bg: #1e293b;
            --border-color: #334155;
            --text-primary: #f8fafc;
            --text-muted: #94a3b8;

            --dswd-blue-light: rgba(30, 64, 175, 0.2);
            --dswd-blue-border: rgba(30, 64, 175, 0.35);

            --dswd-red-light: rgba(220, 38, 38, 0.2);
            --dswd-red-border: rgba(220, 38, 38, 0.35);

            --dswd-yellow-light: rgba(252, 209, 22, 0.15);
        }

        /* ============================================================
           3. Main Container
           ============================================================ */
        .review-container {
            padding: 24px 0;
            color: var(--text-primary);
            min-height: 100vh;
        }

        /* ============================================================
           4. Header Banner
           ============================================================ */
        .rev-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        .rev-banner__content {
            background: linear-gradient(
                135deg,
                var(--dswd-blue) 0%,
                #1e40af 50%,
                var(--dswd-red) 100%
            );
            padding: 28px 24px;
            color: var(--text-white);
            position: relative;
        }

        .rev-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .rev-banner__title {
            font-size: 24px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin: 0 0 8px 0;
        }

        .rev-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 13px;
            max-width: 600px;
            line-height: 1.5;
            margin: 0;
        }

        .rev-banner__ribbon {
            height: 4px;
            width: 100%;
            display: flex;
        }

        .rev-banner__stripe {
            height: 100%;
            width: 33.333%;
        }

        .rev-banner__stripe--blue {
            background-color: var(--dswd-blue);
        }

        .rev-banner__stripe--yellow {
            background-color: var(--dswd-yellow);
        }

        .rev-banner__stripe--red {
            background-color: var(--dswd-red);
        }

        /* ============================================================
           5. Filter Card
           ============================================================ */
        .filter-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 20px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        /* ============================================================
           6. Main Data Card
           ============================================================ */
        .data-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 28px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            margin-bottom: 24px;
        }

        /* ============================================================
           7. Table
           ============================================================ */
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

        /* ============================================================
           8. Category Badges
           ============================================================ */
        .category-badge {
            font-size: 10px;
            font-weight: 800;
            padding: 4px 10px;
            border-radius: 6px;
            text-transform: uppercase;
            display: inline-block;
        }

        .category-badge--senior {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .category-badge--pwd {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }

        .category-badge--soloparent {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
        }

        .category-badge--regular {
            color: #475569;
            background-color: #e2e8f0;
        }

        /* ============================================================
           9. Form Controls
           ============================================================ */
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

        /* ============================================================
           10. Buttons
           ============================================================ */
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

        /* ============================================================
           11. Review Modal Details
           Matches the View User modal design
           ============================================================ */

        .review-detail-avatar-container {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .review-detail-avatar {
            width: 96px;
            height: 96px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #cbd5e1;
            background-color: #f8fafc;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        .review-detail-avatar--empty {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .review-detail-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0 20px;
        }

        .review-detail-grid__span-2 {
            grid-column: span 2;
        }

        .review-detail-row {
            padding: 9px 0;
            border-bottom: 1px solid #f1f5f9;
        }

        .review-detail-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin-bottom: 3px;
        }

        .review-detail-value {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
        }

        .review-detail-value--normal {
            font-weight: 600;
            line-height: 1.5;
            white-space: pre-line;
        }

        /* ============================================================
           12. Dark Mode - Review Modal
           ============================================================ */
        .dark .review-detail-row {
            border-bottom-color: #334155;
        }

        .dark .review-detail-value {
            color: #cbd5e1;
        }

        .dark .review-detail-label {
            color: #94a3b8;
        }

        .dark .review-detail-avatar {
            border-color: #475569;
            background-color: #1e293b;
        }

        /* ============================================================
           13. Dark Mode - Table
           ============================================================ */
        .dark .custom-table th {
            background-color: #1e293b;
            border-bottom-color: #334155;
        }

        .dark .custom-table td {
            border-bottom-color: #334155;
            color: #cbd5e1;
        }

        .dark .custom-table tr:hover td {
            background-color: rgba(30, 64, 175, 0.05);
        }

        /* ============================================================
           14. Responsive
           ============================================================ */
        @media (max-width: 640px) {

            .review-container {
                padding: 16px 0;
            }

            .rev-banner__content {
                padding: 22px 20px;
            }

            .rev-banner__title {
                font-size: 22px;
            }

            .filter-card {
                padding: 16px;
            }

            .data-card {
                padding: 16px;
            }

            .review-detail-grid {
                grid-template-columns: 1fr;
            }

            .review-detail-grid__span-2 {
                grid-column: span 1;
            }

            .review-detail-avatar {
                width: 88px;
                height: 88px;
            }

            .custom-table th,
            .custom-table td {
                white-space: nowrap;
            }
        }
    </style>

    <div class="review-container" x-data="">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="rev-banner">
                <div class="rev-banner__content">
                    <div class="rev-banner__badge">
                        DSWD Approving Officer Portal
                    </div>
                    <h1 class="rev-banner__title">
                        Review and Approval
                    </h1>
                    <p class="rev-banner__description">
                        Assess evaluations completed by Social Workers, review remarks,
                        eligibility justifications, and authorize the final release of program packages.
                    </p>
                </div>
                <div class="rev-banner__ribbon">
                    <div class="rev-banner__stripe rev-banner__stripe--blue"></div>
                    <div class="rev-banner__stripe rev-banner__stripe--yellow"></div>
                    <div class="rev-banner__stripe rev-banner__stripe--red"></div>
                </div>
            </div>
            @if (session('success'))
                <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-xl flex items-center gap-3">
                    <svg
                        class="w-5 h-5 text-green-600"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                        />
                    </svg>
                    <span class="font-medium">
                        {{ session('success') }}
                    </span>
                </div>
            @endif
            <div class="filter-card">
                <form
                    method="GET"
                    action="{{ route('approving-officer.review') }}"
                    class="flex items-end gap-3 flex-wrap"
                >
                    <div class="flex flex-col gap-1.5">
                        <x-input-label
                            for="date"
                            :value="__('Select Queue Date')"
                            class="font-semibold text-gray-700 text-xs"
                        />
                        <x-text-input
                            id="date"
                            name="date"
                            type="date"
                            class="block"
                            value="{{ $selectedDate }}"
                        />
                    </div>
                    <x-primary-button
                        type="submit"
                        class="h-[42px] px-5 btn-primary"
                    >
                        {{ __('Filter Queue') }}
                    </x-primary-button>
                    @if($selectedDate !== now()->format('Y-m-d'))
                        <a href="{{ route('approving-officer.review') }}">
                            <x-secondary-button
                                type="button"
                                class="h-[42px] px-5"
                            >
                                {{ __('Back to Today') }}
                            </x-secondary-button>
                        </a>
                    @endif
                </form>
            </div>
            <div class="data-card">
                <div class="mb-6 flex justify-between items-center border-b pb-4">
                    <div>
                        <h3 class="text-lg font-extrabold text-gray-800">
                            {{ __('Pending Review List') }}
                        </h3>
                        <div class="text-xs text-gray-500 mt-1">
                            {{ __('Showing pending review for:') }}
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
                                <th>Social Worker</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $isToday = $selectedDate === now()->format('Y-m-d');
                            @endphp
                            @forelse($pendingReview as $item)
                                <tr>
                                    <td class="font-bold text-gray-900">
                                        {{ $item->queue->queue_number }}
                                    </td>
                                    <td>
                                        <div class="font-extrabold text-gray-800">
                                            {{ $item->client->first_name }}
                                            {{ $item->client->last_name }}
                                        </div>
                                        <div class="text-xs text-gray-400 font-mono mt-0.5">
                                            {{ $item->client->control_number }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="category-badge category-badge--{{ strtolower(str_replace(' ', '', $item->client->client_category)) }}">
                                            {{ $item->client->client_category }}
                                        </span>
                                    </td>
                                    <td class="font-semibold text-gray-700">
                                        {{ $item->client->assessment?->socialWorker?->first_name ?? __('N/A') }}
                                    </td>
                                    <td>
                                        @if($isToday)
                                            <x-primary-button
                                                x-on:click="$dispatch('open-modal', 'review-modal-{{ $item->id }}')"
                                                class="btn-primary"
                                            >
                                                {{ __('Review') }}
                                            </x-primary-button>
                                        @else
                                            <x-secondary-button
                                                type="button"
                                                disabled
                                                class="opacity-50 cursor-not-allowed"
                                            >
                                                {{ __('View Only') }}
                                            </x-secondary-button>
                                        @endif
                                    </td>
                                </tr>
                                <x-modal
                                    name="review-modal-{{ $item->id }}"
                                    maxWidth="xl"
                                    :show="$errors->any()"
                                >
                                    @php
                                        $assessment = $item->client->assessment;
                                    @endphp
                                    <div class="p-6">
                                        <h2 class="text-lg font-bold text-gray-900 mb-4 pb-2 border-b border-gray-100">
                                            {{ __('Review Application') }}
                                        </h2>
                                        <div class="mb-5">
                                            <div class="text-xs font-bold text-gray-500 uppercase tracking-wide mb-1">
                                                {{ __('Client') }}
                                            </div>
                                            <div class="text-base font-bold text-gray-800">
                                                {{ $item->client->first_name }}
                                                {{ $item->client->last_name }}
                                            </div>
                                            <div class="text-xs text-gray-400 font-mono mt-0.5">
                                                {{ $item->client->control_number }}
                                            </div>
                                        </div>
                                        <div class="review-detail-avatar-container">
                                            @if($assessment?->means_verification)
                                                <img
                                                    src="{{ Storage::url($assessment->means_verification) }}"
                                                    class="review-detail-avatar"
                                                    alt="Proof of appearance"
                                                >
                                            @else
                                                <div class="review-detail-avatar review-detail-avatar--empty">
                                                    <svg
                                                        class="w-8 h-8 text-gray-400"
                                                        fill="none"
                                                        stroke="currentColor"
                                                        stroke-width="1.5"
                                                        viewBox="0 0 24 24"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M3 16.5V7.75A2.75 2.75 0 015.75 5h12.5A2.75 2.75 0 0121 7.75v8.5A2.75 2.75 0 0118.25 19H8.5L4 21v-4.5A2.75 2.75 0 013 13.75V16.5z"
                                                        />
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="review-detail-grid">
                                            <div class="review-detail-row">
                                                <div class="review-detail-label">
                                                    {{ __('Interview Date') }}
                                                </div>
                                                <div class="review-detail-value">
                                                    @if($assessment?->interview_date)
                                                        {{ \Carbon\Carbon::parse($assessment->interview_date)->format('M d, Y') }}
                                                    @else
                                                        —
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="review-detail-row">
                                                <div class="review-detail-label">
                                                    {{ __('Social Worker') }}
                                                </div>
                                                <div class="review-detail-value">
                                                    {{ $item->client->assessment?->socialWorker?->first_name ?? '—' }}
                                                    {{ $item->client->assessment?->socialWorker?->last_name ?? '' }}
                                                </div>
                                            </div>
                                            <div class="review-detail-row review-detail-grid__span-2">
                                                <div class="review-detail-label">
                                                    {{ __('Assessment Findings') }}
                                                </div>
                                                <div class="review-detail-value review-detail-value--normal">
                                                    {{ $assessment?->assessment_findings ?? '—' }}
                                                </div>
                                            </div>
                                            <div class="review-detail-row review-detail-grid__span-2">
                                                <div class="review-detail-label">
                                                    {{ __('Recommendation') }}
                                                </div>
                                                <div class="review-detail-value review-detail-value--normal">
                                                    {{ $assessment?->recommendation ?? '—' }}
                                                </div>
                                            </div>
                                            @if($assessment?->remarks)
                                                <div class="review-detail-row review-detail-grid__span-2">
                                                    <div class="review-detail-label">
                                                        {{ __('Social Worker Remarks') }}
                                                    </div>
                                                    <div class="review-detail-value review-detail-value--normal">
                                                        {{ $assessment->remarks }}
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <form
                                            method="POST"
                                            action="{{ route('approving-officer.review.decide', $item->id) }}"
                                            class="mt-5 pt-5 border-t border-gray-100"
                                        >
                                            @csrf
                                            <div class="mb-4">
                                                <x-input-label
                                                    for="approval_remarks_{{ $item->id }}"
                                                    :value="__('Approval/Return Remarks')"
                                                    class="font-bold text-gray-700"
                                                />
                                                <textarea
                                                    id="approval_remarks_{{ $item->id }}"
                                                    name="approval_remarks"
                                                    rows="3"
                                                    class="mt-1.5 block w-full"
                                                    required
                                                >{{ old('approval_remarks') }}</textarea>
                                                <x-input-error
                                                    :messages="$errors->get('approval_remarks')"
                                                    class="mt-2"
                                                />
                                            </div>
                                            <div class="flex justify-end gap-3 mt-5 pt-4 border-t border-gray-100">
                                                <x-secondary-button
                                                    type="button"
                                                    x-on:click="$dispatch('close-modal', 'review-modal-{{ $item->id }}')"
                                                >
                                                    {{ __('Close') }}
                                                </x-secondary-button>
                                                <x-danger-button
                                                    type="submit"
                                                    name="decision"
                                                    value="Returned"
                                                >
                                                    {{ __('Return to Social Worker') }}
                                                </x-danger-button>
                                                <x-primary-button
                                                    type="submit"
                                                    name="decision"
                                                    value="Approved"
                                                    class="btn-primary"
                                                >
                                                    {{ __('Approve Application') }}
                                                </x-primary-button>
                                            </div>
                                        </form>
                                    </div>
                                </x-modal>
                            @empty
                                <tr>
                                    <td
                                        colspan="5"
                                        class="p-8 text-center text-gray-500 italic"
                                    >
                                        {{ __('No applications pending review.') }}
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{-- Pagination --}}
                <div class="mt-6">
                    {{ $pendingReview->links() }}
                </div>
            </div>
        </div>
    </div>
</x-approving-officer-layout>