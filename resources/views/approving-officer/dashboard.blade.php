<x-approving-officer-layout>
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

         .dashboard {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .dashboard__container {
            max-width: 80rem; /* 1280px */
            margin: 0 auto;
            padding: 0 24px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Banner */
        .dashboard-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
        }

        .dashboard-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 32px 28px;
            color: var(--text-white);
            position: relative;
        }

        .dashboard-banner__badge {
            color: var(--dswd-yellow);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin: 0 0 8px 0;
        }

        .dashboard-banner__title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0 0 10px 0;
            line-height: 1.2;
        }

        .dashboard-banner__description {
            color: rgba(255, 255, 255, 0.85);
            font-size: 14px;
            max-width: 600px;
            line-height: 1.6;
            margin: 0;
        }

        .dashboard-banner__ribbon {
            height: 5px;
            width: 100%;
            display: flex;
        }

        .dashboard-banner__ribbon-stripe {
            height: 100%;
            width: 33.333%;
        }

        .dashboard-banner__ribbon-stripe--blue { background-color: var(--dswd-blue); }
        .dashboard-banner__ribbon-stripe--yellow { background-color: var(--dswd-yellow); }
        .dashboard-banner__ribbon-stripe--red { background-color: var(--dswd-red); }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 14px;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            border: 1px solid #e2e8f0;
            border-bottom: 4px solid transparent;
            transition: var(--transition-smooth);
        }

        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 20px -8px rgba(0, 56, 168, 0.15);
        }

        .stat-card--yellow { border-bottom-color: var(--dswd-yellow); }
        .stat-card--emerald { border-bottom-color: var(--emerald-green); }
        .stat-card--red { border-bottom-color: var(--dswd-red); }

        .stat-card__content {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .stat-card__label {
            font-size: 11px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card__value {
            font-size: 32px;
            font-weight: 900;
            color: var(--text-primary);
            line-height: 1.1;
        }

        .stat-card__icon-container {
            padding: 14px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card__icon-container--yellow { color: #b45309; background-color: var(--dswd-yellow-light); }
        .stat-card__icon-container--emerald { color: var(--emerald-green); background-color: var(--emerald-light); }
        .stat-card__icon-container--red { color: var(--dswd-red); background-color: var(--dswd-red-light); }

        /* Split layout */
        .dashboard-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 24px;
            align-items: start;
        }

        .dashboard-layout__main {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .dashboard-layout__sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        /* Queue Card */
        .queue-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }

        .queue-card__header {
            background: linear-gradient(to right, var(--dswd-blue), #1e40af);
            padding: 20px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--text-white);
        }

        .queue-card__title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
            letter-spacing: -0.01em;
        }

        .queue-card__live-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(255, 255, 255, 0.15);
            padding: 5px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .queue-card__live-dot {
            width: 8px;
            height: 8px;
            background-color: #34d399;
            border-radius: 50%;
            animation: pulseLive 2s infinite;
        }

        .queue-card__body {
            padding: 24px;
        }

        .queue-card__list {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .queue-card__empty-state {
            text-align: center;
            padding: 56px 24px;
            color: var(--text-muted);
        }

        .queue-card__empty-icon {
            width: 48px;
            height: 48px;
            margin: 0 auto 16px;
            color: #94a3b8;
        }

        .queue-card__empty-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 4px;
        }

        .queue-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 20px;
            border-radius: 12px;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: var(--transition-smooth);
        }

        .queue-row:hover {
            border-color: rgba(0, 56, 168, 0.2);
            background-color: rgba(0, 56, 168, 0.02);
            transform: translateX(4px);
        }

        .queue-row__badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
            border: 1px solid var(--dswd-blue-border);
            border-radius: 10px;
            padding: 6px 12px;
            min-width: 90px;
        }

        .queue-row__badge-label {
            font-size: 9px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .queue-row__badge-number {
            font-size: 15px;
            font-weight: 800;
        }

        .queue-row__name {
            font-size: 15px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .queue-row__meta {
            display: flex;
            align-items: center;
            gap: 6px;
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 3px;
        }

        .queue-row__category {
            font-size: 9px;
            font-weight: 800;
            padding: 1px 6px;
            border-radius: 4px;
            text-transform: uppercase;
        }

        .queue-row__category--senior {
            color: #1d4ed8;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
        }

        .queue-row__category--family-heads {
            color: #047857;
            background-color: #ecfdf5;
            border: 1px solid #a7f3d0;
        }

        .queue-row__category--youth-needy-adult {
            color: #7e22ce;
            background-color: #faf5ff;
            border: 1px solid #e9d5ff;
        }

        .queue-row__category--youth-protection {
            color: #b91c1c;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
        }

        .queue-row__category--difficult-circumstances {
            color: #c2410c;
            background-color: #fff7ed;
            border: 1px solid #fed7aa;
        }

        .queue-row__category--default {
            color: #475569;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
        }

        .queue-row__action-btn {
            background-color: var(--dswd-blue);
            color: var(--text-white);
            font-size: 12px;
            font-weight: 700;
            padding: 8px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .queue-row__action-btn:hover {
            background-color: var(--dswd-blue-hover);
        }

        /* Actions Card */
        .actions-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            border: 1px solid #e2e8f0;
        }

        .actions-card__header {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 14px;
            margin-bottom: 18px;
        }

        .actions-card__title {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .actions-card__body {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .actions-card__btn {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 16px;
            border-radius: 12px;
            text-decoration: none;
            background-color: #f8fafc;
            border: 1px solid #f1f5f9;
            transition: var(--transition-smooth);
        }

        .actions-card__btn:hover {
            border-color: rgba(0, 56, 168, 0.2);
            background-color: rgba(0, 56, 168, 0.03);
            transform: translateY(-1px);
        }

        .actions-card__btn-icon {
            padding: 10px;
            border-radius: 10px;
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .actions-card__btn-title {
            font-size: 14px;
            font-weight: 800;
            color: #334155;
        }

        .actions-card__btn-desc {
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 2px;
        }

        @keyframes pulseLive {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(52, 211, 153, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        }

        @media (max-width: 1024px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-layout { grid-template-columns: 1fr; }
        }

        @media (max-width: 640px) {
            .stats-grid { grid-template-columns: 1fr; }
            .queue-row { flex-direction: column; align-items: flex-start; gap: 12px; }
            .queue-row__right { width: 100%; display: flex; justify-content: flex-end; }
        }
    </style>

    <div class="dashboard">
        <div class="dashboard__container">
            <!-- Welcome Header Banner -->
            <div class="dashboard-banner">
                <div class="dashboard-banner__content">
                    <div class="dashboard-banner__badge">DSWD Approving Officer Portal</div>
                    <h1 class="dashboard-banner__title">Welcome back, {{ Auth::user()->first_name }}!</h1>
                    <p class="dashboard-banner__description">
                        Review case assessments submitted by social workers, verify eligibility criteria, and authorize approval actions or return applications.
                    </p>
                </div>
                <div class="dashboard-banner__ribbon">
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--blue"></div>
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--yellow"></div>
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--red"></div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card stat-card--yellow">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Pending Review</span>
                        <span class="stat-card__value" data-stat="pendingReviewCount">{{ $pendingReviewCount }}</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--yellow">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="stat-card stat-card--emerald">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Approved Today</span>
                        <span class="stat-card__value" data-stat="approvedTodayCount">{{ $approvedTodayCount }}</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--emerald">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                <div class="stat-card stat-card--red">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Returned Today</span>
                        <span class="stat-card__value" data-stat="returnedTodayCount">{{ $returnedTodayCount }}</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--red">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Split Main/Sidebar Layout -->
            <div class="dashboard-layout">
                <div class="dashboard-layout__main">
                    <!-- Queue List Card -->
                    <div class="queue-card">
                        <div class="queue-card__header">
                            <div>
                                <h2 class="queue-card__title">Pending Review Queue</h2>
                            </div>
                            <div class="queue-card__live-badge">
                                <span class="queue-card__live-dot"></span>
                                Live Queue
                            </div>
                        </div>

                        <div class="queue-card__body">
                            <div data-live-queue>
                                @if($liveQueue->isEmpty())
                                    <div class="queue-card__empty-state">
                                        <svg class="queue-card__empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                        <h3 class="queue-card__empty-title">Queue is Empty</h3>
                                        <p class="text-sm">There are no client files waiting for review today.</p>
                                    </div>
                                @else
                                    @foreach($liveQueue as $item)
                                        <div class="queue-row">
                                            <div class="flex items-center gap-4">
                                                <div class="queue-row__badge">
                                                    <span class="queue-row__badge-label">Queue No</span>
                                                    <span class="queue-row__badge-number">{{ $item->queue->queue_number }}</span>
                                                </div>
                                                <div>
                                                    <h3 class="queue-row__name">{{ $item->client->first_name }} {{ $item->client->last_name }}</h3>
                                                    <div class="queue-row__meta">
                                                        <span class="font-mono text-xs">{{ $item->client->control_number }}</span>
                                                        <span>•</span>
                                                        <span class="queue-row__category queue-row__category--{{ strtolower(str_replace(' ', '', $item->client->client_category)) }}">
                                                            {{ $item->client->client_category }}
                                                        </span>
                                                        <span>•</span>
                                                        <span>{{ $item->client->program_requested }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="queue-row__right">
                                                <a href="{{ route('approving-officer.review') }}" class="queue-row__action-btn">
                                                    <span>Review Case</span>
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            @if($liveQueue->isNotEmpty())
                                <div class="user-pagination">
                                    {{ $liveQueue->links() }}
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="dashboard-layout__sidebar">
                    <!-- Quick Actions Card -->
                    <div class="actions-card">
                        <div class="actions-card__header">
                            <h2 class="actions-card__title">Quick Actions</h2>
                        </div>
                        <div class="actions-card__body">
                            <a href="{{ route('approving-officer.review') }}" class="actions-card__btn">
                                <div class="actions-card__btn-icon">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="actions-card__btn-title">Review Portal</div>
                                    <div class="actions-card__btn-desc">Approve or return cases.</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        function renderLiveQueue(queue) {
            if (queue.length === 0) {
                return `
                    <div class="queue-card__empty-state">
                        <svg class="queue-card__empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <h3 class="queue-card__empty-title">Queue is Empty</h3>
                        <p class="text-sm">There are no client files waiting for review today.</p>
                    </div>
                `;
            }

            return queue.map(item => `
                <div class="queue-row">
                    <div class="flex items-center gap-4">
                        <div class="queue-row__badge">
                            <span class="queue-row__badge-label">Queue No</span>
                            <span class="queue-row__badge-number">${item.queue_number}</span>
                        </div>
                        <div>
                            <h3 class="queue-row__name">${item.full_name}</h3>
                            <div class="queue-row__meta">
                                <span class="font-mono text-xs">${item.control_number}</span>
                                <span>•</span>
                                <span class="queue-row__category queue-row__category--${item.category_class}">${item.client_category}</span>
                                <span>•</span>
                                <span>${item.program_requested}</span>
                            </div>
                        </div>
                    </div>
                    <div class="queue-row__right">
                        <a href="{{ route('approving-officer.review') }}" class="queue-row__action-btn">
                            <span>Review Case</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    </div>
                </div>
            `).join('');
        }

        window.Echo.channel('approving-officer-dashboard')
            .listen('.dashboard.updated', () => {
                fetch("{{ route('approving-officer.dashboard.data') }}")
                    .then(response => response.json())
                    .then(data => {
                        document.querySelector('[data-stat="pendingReviewCount"]').textContent = data.stats.pendingReviewCount;
                        document.querySelector('[data-stat="approvedTodayCount"]').textContent = data.stats.approvedTodayCount;
                        document.querySelector('[data-stat="returnedTodayCount"]').textContent = data.stats.returnedTodayCount;

                        document.querySelector('[data-live-queue]').innerHTML = renderLiveQueue(data.liveQueue);
                    });
            });
    });
</script>
@endpush
</x-approving-officer-layout>