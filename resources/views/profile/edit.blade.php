<x-app-layout>

    <style>
        /* ==========================================================================
           Profile Page Theme
           ========================================================================== */

        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;
            --dswd-blue-light: rgba(0, 56, 168, 0.06);
            --dswd-blue-border: rgba(0, 56, 168, 0.12);

            --dswd-red: #ce1126;
            --dswd-red-light: rgba(206, 17, 38, 0.06);

            --dswd-yellow: #fcd116;

            --card-bg: #ffffff;
            --border-color: #e2e8f0;

            --text-primary: #0f172a;
            --text-muted: #64748b;

            --transition-smooth:
                all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }


        /* ==========================================================================
           Main Layout
           ========================================================================== */

        .profile-page {
            padding: 24px 0;
            min-height: 100vh;
            color: var(--text-primary);
        }

        .profile-page__container {
            max-width: 80rem;
            margin: 0 auto;
            padding: 0 24px;

            display: flex;
            flex-direction: column;
            gap: 24px;
        }


        /* ==========================================================================
           Header Banner
           ========================================================================== */

        .profile-banner {
            background-color: var(--card-bg);
            border-radius: 16px;
            overflow: hidden;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .profile-banner__content {
            background:
                linear-gradient(
                    135deg,
                    var(--dswd-blue) 0%,
                    #1e40af 50%,
                    var(--dswd-red) 100%
                );

            padding: 24px;

            color: white;
            position: relative;
        }

        .profile-banner__bg-icon {
            position: absolute;
            right: 0;
            top: 0;

            opacity: 0.08;

            transform: translate(24px, -24px);

            pointer-events: none;
        }

        .profile-banner__badge {
            color: var(--dswd-yellow);

            font-size: 12px;
            font-weight: 700;

            letter-spacing: 0.05em;
            text-transform: uppercase;

            margin: 0 0 6px 0;
        }

        .profile-banner__title {
            font-size: 28px;
            font-weight: 800;

            letter-spacing: -0.025em;

            margin: 0 0 8px 0;
        }

        .profile-banner__description {
            color: rgba(255, 255, 255, 0.8);

            font-size: 14px;

            max-width: 650px;

            line-height: 1.6;

            margin: 0;
        }


        /* ==========================================================================
           Philippine Color Ribbon
           ========================================================================== */

        .profile-banner__ribbon {
            height: 4px;
            width: 100%;

            display: flex;
        }

        .profile-banner__ribbon-stripe {
            height: 100%;
            width: 33.333%;
        }

        .profile-banner__ribbon-stripe--blue {
            background-color: var(--dswd-blue);
        }

        .profile-banner__ribbon-stripe--yellow {
            background-color: var(--dswd-yellow);
        }

        .profile-banner__ribbon-stripe--red {
            background-color: var(--dswd-red);
        }


        /* ==========================================================================
           Profile Sections
           ========================================================================== */

        .profile-section {
            background-color: var(--card-bg);

            border-radius: 12px;

            overflow: hidden;

            box-shadow:
                0 1px 3px rgba(0, 0, 0, 0.05);

            transition: var(--transition-smooth);
        }

        .profile-section:hover {
            box-shadow:
                0 10px 25px -5px rgba(0, 56, 168, 0.08),
                0 0 1px rgba(0, 56, 168, 0.05);
        }


        /* ==========================================================================
           Section Header
           ========================================================================== */

        .profile-section__header {
            padding: 18px 24px;

            border-bottom: 1px solid var(--border-color);

            display: flex;
            align-items: center;

            gap: 12px;
        }

        .profile-section__icon {
            width: 38px;
            height: 38px;

            border-radius: 10px;

            display: flex;
            align-items: center;
            justify-content: center;

            flex-shrink: 0;
        }

        .profile-section__icon--blue {
            color: var(--dswd-blue);
            background-color: var(--dswd-blue-light);
        }

        .profile-section__icon--yellow {
            color: #b45309;
            background-color: rgba(252, 209, 22, 0.12);
        }

        .profile-section__icon--red {
            color: var(--dswd-red);
            background-color: var(--dswd-red-light);
        }

        .profile-section__heading {
            font-size: 15px;
            font-weight: 800;

            color: var(--text-primary);

            margin: 0;
        }

        .profile-section__description {
            font-size: 12px;

            color: var(--text-muted);

            margin: 2px 0 0 0;
        }


        /* ==========================================================================
           Form Content
           ========================================================================== */

        .profile-section__body {
            padding: 24px;
        }

        .profile-section__body-inner {
            max-width: 720px;
        }


        /* ==========================================================================
           Danger Section
           ========================================================================== */

        .profile-section--danger {
            border-left: 4px solid var(--dswd-red);
        }


        /* ==========================================================================
           Responsive
           ========================================================================== */

        @media (max-width: 640px) {

            .profile-page {
                padding: 16px 0;
            }

            .profile-page__container {
                padding: 0 16px;
                gap: 16px;
            }

            .profile-banner__content {
                padding: 20px;
            }

            .profile-banner__title {
                font-size: 24px;
            }

            .profile-banner__description {
                font-size: 13px;
            }

            .profile-section__header {
                padding: 16px 18px;
            }

            .profile-section__body {
                padding: 18px;
            }

        }

    </style>


    <div class="profile-page">
        <div class="profile-page__container">
            {{-- ================================================================
                 Profile Header
                 ================================================================ --}}
            <div class="profile-banner">
                <div class="profile-banner__content">
                    <div class="profile-banner__bg-icon">
                        <svg width="240" height="240" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4
                                1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8
                                1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"
                            />
                        </svg>
                    </div>
                    <p class="profile-banner__badge">DSWD Operations Control Hub</p>
                        <h1 class="profile-banner__title">Profile Settings</h1>
                    <p class="profile-banner__description">
                        Manage your account information, update your password,
                        and control your account settings.
                    </p>
                </div>
                <div class="profile-banner__ribbon">
                    <div class="profile-banner__ribbon-stripe profile-banner__ribbon-stripe--blue"></div>
                    <div
                        class="profile-banner__ribbon-stripe
                               profile-banner__ribbon-stripe--yellow">
                    </div>
                    <div
                        class="profile-banner__ribbon-stripe
                               profile-banner__ribbon-stripe--red">
                    </div>
                </div>
            </div>
            {{-- ================================================================
                 Profile Information
                 ================================================================ --}}
            <div class="profile-section">
                <div class="profile-section__header">
                    <div class="profile-section__icon profile-section__icon--blue">
                        <svg
                            width="20"
                            height="20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2" />
                            <circle cx="12" cy="7" r="4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="profile-section__heading">
                            {{ __('Profile Information') }}
                        </h2>
                        <p class="profile-section__description">
                            {{ __('Update your account information and contact details.') }}
                        </p>
                    </div>
                </div>
                <div class="profile-section__body">
                    <div class="profile-section__body-inner">
                        @include(
                            'profile.partials.update-profile-information-form'
                        )
                    </div>
                </div>
            </div>
            {{-- ================================================================
                 Update Password
                 ================================================================ --}}
            <div class="profile-section">
                <div class="profile-section__header">
                    <div class="profile-section__icon profile-section__icon--yellow">
                        <svg
                            width="20"
                            height="20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <rect
                                x="3"
                                y="11"
                                width="18"
                                height="10"
                                rx="2"
                            />
                            <path d="M7 11V7a5 5 0 0110 0v4" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="profile-section__heading">
                            {{ __('Update Password') }}
                        </h2>
                        <p class="profile-section__description">
                            {{ __('Ensure your account is using a secure password.') }}
                        </p>
                    </div>
                </div>
                <div class="profile-section__body">
                    <div class="profile-section__body-inner">
                        @include(
                            'profile.partials.update-password-form'
                        )
                    </div>
                </div>
            </div>
            {{-- ================================================================
                 Delete Account
                 ================================================================ --}}
            <div class="profile-section profile-section--danger">
                <div class="profile-section__header">
                    <div class="profile-section__icon profile-section__icon--red">
                        <svg
                            width="20"
                            height="20"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            viewBox="0 0 24 24"
                        >
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v5" />
                            <path d="M14 11v5" />
                        </svg>
                    </div>
                    <div>
                        <h2 class="profile-section__heading">
                            {{ __('Delete Account') }}
                        </h2>
                        <p class="profile-section__description">
                            {{ __('Permanently delete your account and all associated data.') }}
                        </p>
                    </div>
                </div>
                <div class="profile-section__body">
                    <div class="profile-section__body-inner">
                        @include(
                            'profile.partials.delete-user-form'
                        )
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>