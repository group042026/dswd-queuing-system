<x-admin-layout>
    <style>
        /* ==========================================================================
           1. Core Design System & Theme Variables
           ========================================================================== */
        :root {
            /* DSWD Logo Branding Colors */
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

            /* Theme Colors */
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

            --emerald-green: #34d399;
            --emerald-light: rgba(52, 211, 153, 0.1);
            --emerald-border: rgba(52, 211, 153, 0.25);
        }

        /* ==========================================================================
           2. Dashboard Container & Grid Layouts
           ========================================================================== */
        .dashboard {
            padding: 24px 0;
            /* background-color: var(--bg-gray); */
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

        /* Banner Component */
        .dashboard-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border:  none;
        }

        .dashboard-banner__content {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            padding: 24px;
            color: var(--text-white);
            position: relative;
        }

        .dashboard-banner__bg-icon {
            position: absolute;
            right: 0;
            top: 0;
            opacity: 0.1;
            transform: translate(24px, -24px);
            pointer-events: none;
        }

        .dashboard-banner__badge {
            color: var(--dswd-yellow);
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin: 0 0 6px 0;
        }

        .dashboard-banner__title {
            font-size: 28px;
            font-weight: 800;
            letter-spacing: -0.025em;
            margin: 0 0 8px 0;
        }

        .dashboard-banner__description {
            color: rgba(255, 255, 255, 0.8);
            font-size: 14px;
            max-width: 576px;
            line-height: 1.6;
            margin: 0;
        }

        .dashboard-banner__ribbon {
            height: 4px;
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

        /* Stats Grid Component */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
        }

        .stat-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border:  none;
            border-bottom-width: 4px;
            transition: var(--transition-smooth);
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px -5px rgba(0, 56, 168, 0.1), 0 0 1px rgba(0, 56, 168, 0.05);
        }

        .stat-card--blue { border-bottom-color: var(--dswd-blue); }
        .stat-card--yellow { border-bottom-color: var(--dswd-yellow); }
        .stat-card--emerald { border-bottom-color: var(--emerald-green); }
        .stat-card--red { border-bottom-color: var(--dswd-red); }

        .stat-card__content {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .stat-card__label {
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .stat-card__value {
            font-size: 30px;
            font-weight: 950;
            color: var(--text-primary);
            line-height: 1.2;
        }

        .stat-card__badge {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 9999px;
            align-self: flex-start;
        }

        .stat-card__badge--blue { color: var(--dswd-blue); background-color: var(--dswd-blue-light); }
        .stat-card__badge--yellow { color: #854d0e; background-color: var(--dswd-yellow-light); }
        .stat-card__badge--emerald { color: var(--emerald-green); background-color: var(--emerald-light); }
        .stat-card__badge--red { color: var(--dswd-red); background-color: var(--dswd-red-light); }

        .stat-card__icon-container {
            padding: 12px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stat-card__icon-container--blue { color: var(--dswd-blue); background-color: var(--dswd-blue-light); }
        .stat-card__icon-container--yellow { color: #b45309; background-color: var(--dswd-yellow-light); }
        .stat-card__icon-container--emerald { color: var(--emerald-green); background-color: var(--emerald-light); }
        .stat-card__icon-container--red { color: var(--dswd-red); background-color: var(--dswd-red-light); }

        /* Dashboard Layout Split Component */
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

        /* ==========================================================================
           3. Queue Card & Rows Component
           ========================================================================== */
        .queue-card {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border:  none;
        }

        .queue-card__header {
            background: linear-gradient(to right, var(--dswd-blue), #1e40af);
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            color: var(--text-white);
        }

        .queue-card__title {
            font-size: 18px;
            font-weight: 800;
            margin: 0;
        }

        .queue-card__subtitle {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.7);
            margin: 2px 0 0 0;
        }

        .queue-card__live-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background-color: rgba(255, 255, 255, 0.1);
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .queue-card__live-dot {
            width: 10px;
            height: 10px;
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
            gap: 16px;
        }

        .queue-card__empty-state {
            text-align: center;
            padding: 64px 0;
            color: var(--text-muted);
        }

        .queue-card__empty-icon {
            height: 56px;
            width: 56px;
            margin: 0 auto 12px;
            color: #cbd5e1;
        }

        .queue-card__empty-text {
            font-size: 14px;
            font-weight: 600;
        }

        .queue-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px;
            border-radius: 12px;
            border:  none;
            gap: 16px;
            transition: var(--transition-smooth);
        }

        .queue-row:hover {
            border-color: rgba(0, 56, 168, 0.2);
            background-color: rgba(0, 56, 168, 0.02);
        }

        .queue-row__left {
            display: flex;
            align-items: flex-start;
            gap: 16px;
        }

        .queue-row__badge {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
            border: 1px solid var(--dswd-blue-border);
            border-radius: 12px;
            padding: 8px 16px;
            min-width: 100px;
            text-align: center;
        }

        .queue-row__badge-label {
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .queue-row__badge-number {
            font-size: 16px;
            font-weight: 900;
            font-family: monospace;
        }

        .queue-row__identity {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .queue-row__name {
            font-size: 14px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .queue-row__meta {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 6px;
            font-size: 12px;
            font-weight: 600;
            color: var(--text-muted);
        }

        .queue-row__control-number {
            font-family: monospace;
            color: #94a3b8;
        }

        .queue-row__divider {
            color: #cbd5e1;
        }

        .queue-row__category {
            font-size: 10px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            border: 1px solid;
        }

        .queue-row__category--senior {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border-color: var(--dswd-blue-border);
        }

        .queue-row__category--pwd {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border-color: var(--dswd-red-border);
        }

        .queue-row__category--solo {
            color: #854d0e;
            background-color: var(--dswd-yellow-light);
            border-color: rgba(252, 209, 22, 0.3);
        }

        .queue-row__category--regular {
            color: #334155;
            background-color: #f1f5f9;
            border-color: #e2e8f0;
        }

        .queue-row__right {
            display: flex;
            align-items: center;
            gap: 24px;
        }

        .queue-row__program-details {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .queue-row__program {
            font-size: 12px;
            font-weight: 700;
            color: #1e293b;
        }

        .queue-row__program-value {
            color: var(--dswd-blue);
        }

        .queue-row__step {
            font-size: 11px;
            color: var(--text-muted);
            font-weight: 600;
        }

        .queue-row__status-container {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 6px;
        }

        .queue-row__status-badge {
            font-size: 12px;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 9999px;
            border: 1px solid;
        }

        .queue-row__status-badge--processing {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
            border-color: var(--dswd-blue-border);
        }

        .queue-row__status-badge--completed {
            color: var(--emerald-green);
            background-color: var(--emerald-light);
            border-color: var(--emerald-border);
        }

        .queue-row__status-badge--waiting {
            color: #b45309;
            background-color: #fffbeb;
            border-color: #fde68a;
        }

        .queue-row__status-badge--approved {
            color: var(--emerald-green);
            background-color: var(--emerald-light);
            border-color: var(--emerald-border);
        }

        .queue-row__status-badge--disapproved {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border-color: var(--dswd-red-border);
        }

        .queue-row__status-badge--cancelled {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
            border-color: var(--dswd-red-border);
        }

        .queue-row__time {
            font-size: 10px;
            color: var(--text-muted);
            font-family: monospace;
            font-weight: 500;
        }

        /* ==========================================================================
           4. Demographics & Quick Actions Sidebar Components
           ========================================================================== */
        .demographics-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border:  none;
        }

        .demographics-card__header {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 16px;
            margin-bottom: 24px;
        }

        .demographics-card__title {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .demographics-card__subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin: 4px 0 0 0;
        }

        .demographics-card__body {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .demographics-card__item {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .demographics-card__meta {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            font-weight: 700;
        }

        .demographics-card__label {
            color: #475569;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .demographics-card__label-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
        }

        .demographics-card__label-dot--senior { background-color: var(--dswd-blue); }
        .demographics-card__label-dot--pwd { background-color: var(--dswd-red); }
        .demographics-card__label-dot--solo { background-color: var(--dswd-yellow); }
        .demographics-card__label-dot--regular { background-color: #6b7280; }

        .demographics-card__value {
            color: #1e293b;
        }

        .demographics-card__bar-bg {
            width: 100%;
            background-color: #f1f5f9;
            height: 8px;
            border-radius: 9999px;
            overflow: hidden;
        }

        .demographics-card__bar-fill {
            height: 100%;
            border-radius: 9999px;
            transition: width 0.7s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .demographics-card__bar-fill--senior { background-color: var(--dswd-blue); }
        .demographics-card__bar-fill--pwd { background-color: var(--dswd-red); }
        .demographics-card__bar-fill--solo { background-color: var(--dswd-yellow); }
        .demographics-card__bar-fill--regular { background-color: #6b7280; }

        .actions-card {
            background-color: var(--card-bg);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
            border:  none;
        }

        .actions-card__header {
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 16px;
            margin-bottom: 20px;
        }

        .actions-card__title {
            font-size: 16px;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        .actions-card__subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin: 4px 0 0 0;
        }

        .actions-card__body {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .actions-card__link {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px;
            border-radius: 12px;
            border:  none;
            text-decoration: none;
            transition: var(--transition-smooth);
        }

        .actions-card__link--operators {
            border-left: 4px solid var(--dswd-blue);
        }

        .actions-card__link--operators:hover {
            border-color: rgba(0, 56, 168, 0.2);
            border-left-color: var(--dswd-blue);
            background-color: rgba(0, 56, 168, 0.02);
        }

        .actions-card__link--monitor {
            border-left: 4px solid var(--dswd-yellow);
        }

        .actions-card__link--monitor:hover {
            border-color: rgba(252, 209, 22, 0.3);
            border-left-color: var(--dswd-yellow);
            background-color: rgba(252, 209, 22, 0.03);
        }

        .actions-card__link-icon {
            padding: 8px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: var(--transition-smooth);
        }

        .actions-card__link--operators .actions-card__link-icon {
            background-color: var(--dswd-blue-light);
            color: var(--dswd-blue);
        }

        .actions-card__link--operators:hover .actions-card__link-icon {
            background-color: var(--dswd-blue);
            color: var(--text-white);
        }

        .actions-card__link--monitor .actions-card__link-icon {
            background-color: var(--dswd-yellow-light);
            color: #b45309;
        }

        .actions-card__link--monitor:hover .actions-card__link-icon {
            background-color: var(--dswd-yellow);
            color: #78350f;
        }

        .actions-card__link-content {
            display: flex;
            flex-direction: column;
        }

        .actions-card__link-title {
            font-size: 14px;
            font-weight: 800;
            color: #334155;
            transition: color 0.2s ease;
        }

        .actions-card__link--operators:hover .actions-card__link-title {
            color: var(--dswd-blue);
        }

        .actions-card__link--monitor:hover .actions-card__link-title {
            color: #b45309;
        }

        .actions-card__link-desc {
            font-size: 10px;
            color: var(--text-muted);
            font-weight: 600;
            margin-top: 2px;
        }

        .actions-card__footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-top: 16px;
            border-top: 1px solid #f1f5f9;
            font-size: 10px;
            font-weight: 700;
            color: var(--text-muted);
            margin-top: 24px;
        }

        .actions-card__status {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .actions-card__status-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background-color: #10b981;
            animation: pulseLive 2s infinite;
        }

        /* ==========================================================================
           5. Animations & Keyframes
           ========================================================================== */
        @keyframes pulseLive {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 6px rgba(52, 211, 153, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(52, 211, 153, 0); }
        }

        /* ==========================================================================
           6. Responsive Media Queries
           ========================================================================== */
        @media (max-width: 1024px) {
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .dashboard-layout {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 640px) {
            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard__container {
                padding: 0 16px;
            }

            .queue-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .queue-row__right {
                width: 100%;
                border-top: 1px solid #f1f5f9;
                padding-top: 12px;
                justify-content: space-between;
            }

            .dashboard-banner__title {
                font-size: 24px;
            }
        }
    </style>

    <div class="dashboard">
        <div class="dashboard__container">

            <!-- Welcome Header Banner with DSWD Branding Colors -->
            <div class="dashboard-banner">
                <div class="dashboard-banner__content">
                    <!-- Subtle background logo mark -->
                    <div class="dashboard-banner__bg-icon">
                        <svg width="240" height="240" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                        </svg>
                    </div>
                    <div class="dashboard-banner__info">
                        <p class="dashboard-banner__badge">DSWD Queuing System Control Panel</p>
                        <h1 class="dashboard-banner__title">Welcome, {{ Auth::user()->first_name }}!</h1>
                        <p class="dashboard-banner__description">
                            Monitor live queuing activities, manage system operators, and track validation efficiency in real-time.
                        </p>
                    </div>
                </div>
                <!-- Signature Tri-color Brand Stripe -->
                <div class="dashboard-banner__ribbon">
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--blue"></div>
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--yellow"></div>
                    <div class="dashboard-banner__ribbon-stripe dashboard-banner__ribbon-stripe--red"></div>
                </div>
            </div>

            <!-- Stats Grid with Accent Borders & DSWD colors -->
            <div class="stats-grid">
                <!-- Total Queue Card -->
                <div class="stat-card stat-card--blue">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Total Queues Today</span>
                        <div class="stat-card__value" data-stat="totalQueuesToday">{{ $totalQueuesToday }}</div>
                        <span class="stat-card__badge stat-card__badge--blue">Active Tickets</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--blue">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                        </svg>
                    </div>
                </div>

                <!-- Currently Serving Card -->
                <div class="stat-card stat-card--yellow">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Currently Serving</span>
                        <div class="stat-card__value" data-stat="servingQueuesToday">{{ $servingQueuesToday }}</div>
                        <span class="stat-card__badge stat-card__badge--yellow">At Counter Desk</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--yellow">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                        </svg>
                    </div>
                </div>

                <!-- Completed Services Card -->
                <div class="stat-card stat-card--emerald">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Completed Today</span>
                        <div class="stat-card__value" data-stat="completedTodayCount">{{ $completedTodayCount }}</div>
                        <span class="stat-card__badge stat-card__badge--emerald">Assessed & Closed</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--emerald">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <polyline points="20 6 9 17 4 12"/>
                        </svg>
                    </div>
                </div>

                <!-- Cancelled Card -->
                <div class="stat-card stat-card--red">
                    <div class="stat-card__content">
                        <span class="stat-card__label">Cancelled / No Show</span>
                        <div class="stat-card__value" data-stat="cancelledQueuesToday">{{ $cancelledQueuesToday }}</div>
                        <span class="stat-card__badge stat-card__badge--red">Cancelled Tickets</span>
                    </div>
                    <div class="stat-card__icon-container stat-card__icon-container--red">
                        <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Two Column Main Layout: Highlighted Queueing List on the left (2/3 width) -->
            <div class="dashboard-layout">

                <!-- Left: Highlighted Live Queueing List -->
                <div class="queue-card dashboard-layout__main">
                    <div class="queue-card__header">
                        <div class="queue-card__title-group">
                            <h2 class="queue-card__title">Live Queuing Activity List</h2>
                            <p class="queue-card__subtitle">Real-time status updates of active clients</p>
                        </div>
                        <div class="queue-card__live-badge">
                            <span class="queue-card__live-dot"></span>
                            Live Updates
                        </div>
                    </div>

                    <div class="queue-card__body">
                        <div class="queue-card__list" data-recent-processings>
                            @if ($recentProcessings->isEmpty())
                                <div class="queue-card__empty-state">
                                    <svg class="queue-card__empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <span class="queue-card__empty-text">No active queue entries recorded today.</span>
                                </div>
                            @else
                                @foreach ($recentProcessings as $processing)
                                    <div class="queue-row">
                                        <!-- Left Side: Queue Number & Client Identity -->
                                        <div class="queue-row__left">
                                            <!-- Queue Number Badge -->
                                            <div class="queue-row__badge">
                                                <span class="queue-row__badge-label">Queue No</span>
                                                <span class="queue-row__badge-number">{{ substr($processing->queue->queue_number, -3) }}</span>
                                            </div>

                                            <div class="queue-row__identity">
                                                <h4 class="queue-row__name">
                                                    {{ $processing->client->first_name }} {{ $processing->client->last_name }}
                                                </h4>

                                                <div class="queue-row__meta">
                                                    <span class="queue-row__control-number">{{ $processing->client->control_number }}</span>
                                                    <span class="queue-row__divider">•</span>
                                                    @php
                                                        $catModifier = match($processing->client->client_category) {
                                                            'Senior'      => 'queue-row__category--senior',
                                                            'PWD'         => 'queue-row__category--pwd',
                                                            'Solo Parent' => 'queue-row__category--solo',
                                                            default       => 'queue-row__category--regular'
                                                        };
                                                    @endphp
                                                    <span class="queue-row__category {{ $catModifier }}">
                                                        {{ $processing->client->client_category }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Right Side: Program, Current Step & Status Badges -->
                                        <div class="queue-row__right">
                                            <div class="queue-row__program-details">
                                                <div class="queue-row__program">
                                                    Program: <span class="queue-row__program-value">{{ $processing->client->program_requested }}</span>
                                                </div>
                                                <div class="queue-row__step">
                                                    Step: {{ $processing->current_step }}
                                                </div>
                                            </div>

                                            <div class="queue-row__status-container">
                                                @php
                                                    $status = $processing->current_status;
                                                    $statusModifier = match($status) {
                                                        'Processing' => 'queue-row__status-badge--processing',
                                                        'Completed'  => 'queue-row__status-badge--completed',
                                                        'Waiting'    => 'queue-row__status-badge--waiting',
                                                        'Approved'   => 'queue-row__status-badge--approved',
                                                        'Disapproved'=> 'queue-row__status-badge--disapproved',
                                                        'Cancelled'  => 'queue-row__status-badge--cancelled',
                                                        default      => ''
                                                    };
                                                @endphp
                                                <span class="queue-row__status-badge {{ $statusModifier }}">
                                                    {{ $status }}
                                                </span>
                                                <span class="queue-row__time">
                                                    {{ $processing->start_time ? $processing->start_time->format('h:i A') : 'N/A' }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                        @if ($recentProcessings->isNotEmpty())
                            <div class="user-pagination">
                                {{ $recentProcessings->links() }}
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column: Quick Stats & Actions -->
                <div class="dashboard-layout__sidebar">

                    <!-- Client Demographics (DSWD Themed) -->
                    <div class="demographics-card">
                        <div class="demographics-card__header">
                            <h3 class="demographics-card__title">Demographics Today</h3>
                            <p class="demographics-card__subtitle">Total distribution of client registrations</p>
                        </div>

                        <div class="demographics-card__body">
                            <!-- Senior citizens -->
                            <div class="demographics-card__item">
                                <div class="demographics-card__meta">
                                    <span class="demographics-card__label">
                                        <span class="demographics-card__label-dot demographics-card__label-dot--senior"></span>
                                        Seniors
                                    </span>
                                    <span class="demographics-card__value" data-stat="seniorsCount">{{ $seniorsCount }}</span>
                                </div>
                                <div class="demographics-card__bar-bg">
                                    @php $senPercent = $totalQueuesToday > 0 ? ($seniorsCount / $totalQueuesToday) * 100 : 0; @endphp
                                    <div class="demographics-card__bar-fill demographics-card__bar-fill--senior" style="width: {{ $senPercent }}%"></div>
                                </div>
                            </div>

                            <!-- PWD -->
                            <div class="demographics-card__item">
                                <div class="demographics-card__meta">
                                    <span class="demographics-card__label">
                                        <span class="demographics-card__label-dot demographics-card__label-dot--pwd"></span>
                                        PWDs
                                    </span>
                                    <span class="demographics-card__value" data-stat="pwdsCount">{{ $pwdsCount }}</span>
                                </div>
                                <div class="demographics-card__bar-bg">
                                    @php $pwdPercent = $totalQueuesToday > 0 ? ($pwdsCount / $totalQueuesToday) * 100 : 0; @endphp
                                    <div class="demographics-card__bar-fill demographics-card__bar-fill--pwd" style="width: {{ $pwdPercent }}%"></div>
                                </div>
                            </div>

                            <!-- Solo Parent -->
                            <div class="demographics-card__item">
                                <div class="demographics-card__meta">
                                    <span class="demographics-card__label">
                                        <span class="demographics-card__label-dot demographics-card__label-dot--solo"></span>
                                        Solo Parents
                                    </span>
                                    <span class="demographics-card__value" data-stat="soloParentsCount">{{ $soloParentsCount }}</span>
                                </div>
                                <div class="demographics-card__bar-bg">
                                    @php $soloPercent = $totalQueuesToday > 0 ? ($soloParentsCount / $totalQueuesToday) * 100 : 0; @endphp
                                    <div class="demographics-card__bar-fill demographics-card__bar-fill--solo" style="width: {{ $soloPercent }}%"></div>
                                </div>
                            </div>

                            <!-- Regular -->
                            <div class="demographics-card__item">
                                <div class="demographics-card__meta">
                                    <span class="demographics-card__label">
                                        <span class="demographics-card__label-dot demographics-card__label-dot--regular"></span>
                                        Regulars
                                    </span>
                                    <span class="demographics-card__value" data-stat="regularsCount">{{ $regularsCount }}</span>
                                </div>
                                <div class="demographics-card__bar-bg">
                                    @php $regPercent = $totalQueuesToday > 0 ? ($regularsCount / $totalQueuesToday) * 100 : 0; @endphp
                                    <div class="demographics-card__bar-fill demographics-card__bar-fill--regular" style="width: {{ $regPercent }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions Card (Themed) -->
                    <div class="actions-card">
                        <div class="actions-card__header">
                            <h3 class="actions-card__title">Administrative Links</h3>
                            <p class="actions-card__subtitle">Manage components from here</p>
                        </div>

                        <div class="actions-card__body">
                            <a href="{{ route('admin.users.list') }}" class="actions-card__link actions-card__link--operators">
                                <div class="actions-card__link-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/>
                                    </svg>
                                </div>
                                <div class="actions-card__link-content">
                                    <span class="actions-card__link-title">Manage Operators</span>
                                    <span class="actions-card__link-desc">Operators registered: {{ $totalUsers }}</span>
                                </div>
                            </a>

                            <a href="{{ route('admin.queue.monitor') }}" class="actions-card__link actions-card__link--monitor">
                                <div class="actions-card__link-icon">
                                    <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                        <path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                                    </svg>
                                </div>
                                <div class="actions-card__link-content">
                                    <span class="actions-card__link-title">Queue Monitor</span>
                                    <span class="actions-card__link-desc">Real-time control board</span>
                                </div>
                            </a>
                        </div>

                        <div class="actions-card__footer">
                            <span class="actions-card__status">
                                <span class="actions-card__status-dot"></span>
                                System: Online
                            </span>
                            <span class="actions-card__time">Server Time: {{ now()->format('h:i A') }}</span>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('Dashboard script loaded, attempting to subscribe...');

            window.Echo.channel('admin-dashboard')
                .listen('.dashboard.updated', () => {
                    fetch("{{ route('admin.dashboard.data') }}")
                        .then(response => response.json())
                        .then(data => {
                            // Update stats cards
                            document.querySelector('[data-stat="totalQueuesToday"]').textContent = data.stats.totalQueuesToday;
                            document.querySelector('[data-stat="servingQueuesToday"]').textContent = data.stats.servingQueuesToday;
                            document.querySelector('[data-stat="completedTodayCount"]').textContent = data.stats.completedTodayCount;
                            document.querySelector('[data-stat="cancelledQueuesToday"]').textContent = data.stats.cancelledQueuesToday;

                            // Update demographics
                            document.querySelector('[data-stat="seniorsCount"]').textContent = data.stats.seniorsCount;
                            document.querySelector('[data-stat="pwdsCount"]').textContent = data.stats.pwdsCount;
                            document.querySelector('[data-stat="soloParentsCount"]').textContent = data.stats.soloParentsCount;
                            document.querySelector('[data-stat="regularsCount"]').textContent = data.stats.regularsCount;

                            // Update recent processings list
                            const listContainer = document.querySelector('[data-recent-processings]');
                            if (listContainer) {
                                listContainer.innerHTML = data.recentProcessings.map(p => `
                                    <div class="queue-row">
                                        <div class="queue-row__left">
                                            <div class="queue-row__badge">
                                                <span class="queue-row__badge-label">Queue No</span>
                                                <span class="queue-row__badge-number">${p.queue_number_short}</span>
                                            </div>
                                            <div class="queue-row__identity">
                                                <h4 class="queue-row__name">${p.full_name}</h4>
                                                <div class="queue-row__meta">
                                                    <span class="queue-row__control-number">${p.control_number}</span>
                                                    <span class="queue-row__divider">•</span>
                                                    <span class="queue-row__category">${p.client_category}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="queue-row__right">
                                            <div class="queue-row__program-details">
                                                <div class="queue-row__program">Program: <span class="queue-row__program-value">${p.program_requested}</span></div>
                                                <div class="queue-row__step">Step: ${p.current_step}</div>
                                            </div>
                                            <div class="queue-row__status-container">
                                                <span class="queue-row__status-badge">${p.current_status}</span>
                                                <span class="queue-row__time">${p.start_time ?? 'N/A'}</span>
                                            </div>
                                        </div>
                                    </div>
                                `).join('');
                            }
                        });
                });
        });
            
    </script>
    @endpush
</x-admin-layout>


