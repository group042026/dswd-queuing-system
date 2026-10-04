<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Live Queue Board</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600,700,850,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* ==========================================================================
        Queue Board Dark Mode
        ========================================================================== */

        .queue-dark {
            background-color: #0f172a !important;
            color: #e2e8f0 !important;
        }

        .queue-dark main {
            background-color: #0f172a;
        }

        .queue-dark .bg-white {
            background-color: #1e293b !important;
        }

        .queue-dark .border-slate-200,
        .queue-dark .border-slate-100 {
            border-color: #334155 !important;
        }

        .queue-dark .shadow-md {
            box-shadow:
                0 4px 12px rgba(0, 0, 0, 0.35);
        }

        /* Card header and lane sections */
        .queue-dark .bg-slate-50 {
            background-color: #273449 !important;
        }

        .queue-dark .bg-slate-100 {
            background-color: #0f172a !important;
        }

        .queue-dark .bg-red-50 {
            background-color: rgba(127, 29, 29, 0.28) !important;
        }

        .queue-dark .bg-red-50\/20 {
            background-color: rgba(127, 29, 29, 0.18) !important;
        }

        .queue-dark .bg-red-50\/50 {
            background-color: rgba(127, 29, 29, 0.25) !important;
        }

        /* Waiting tickets */
        .queue-dark .border-slate-200\/60 {
            border-color: #475569 !important;
        }

        .queue-dark .border-red-100 {
            border-color: rgba(248, 113, 113, 0.35) !important;
        }

        .queue-dark .bg-amber-50 {
            background-color: rgba(120, 53, 15, 0.28) !important;
        }

        .queue-dark .border-amber-200 {
            border-color: rgba(251, 191, 36, 0.4) !important;
        }

        /* Text colors */
        .queue-dark .text-slate-900 {
            color: #f8fafc !important;
        }

        .queue-dark .text-slate-800,
        .queue-dark .text-slate-700 {
            color: #e2e8f0 !important;
        }

        .queue-dark .text-slate-600 {
            color: #cbd5e1 !important;
        }

        .queue-dark .text-slate-500,
        .queue-dark .text-slate-400 {
            color: #94a3b8 !important;
        }

        .queue-dark .text-slate-300 {
            color: #64748b !important;
        }

        /* Preserve the colored counter badges and lane indicators */
        .queue-dark .bg-\[\#0038a8\] {
            background-color: #0038a8 !important;
        }

        .queue-dark .bg-\[\#fcd116\] {
            background-color: #fcd116 !important;
        }

        .queue-dark .bg-\[\#ce1126\] {
            background-color: #ce1126 !important;
        }

        .queue-dark .bg-emerald-600 {
            background-color: #059669 !important;
        }

        .queue-dark .text-\[\#854d0e\] {
            color: #854d0e !important;
        }

        /* Keep footer/header colors unchanged */
        .queue-dark header,
        .queue-dark footer {
            filter: none;
        }
        .flash-card {
            animation: bgFlash 0.6s ease-in-out 3;
        }
        @keyframes bgFlash {
            0%, 100% { background-color: #ffffff; }
            50% { background-color: rgba(252, 209, 22, 0.2); border-color: #fcd116; }
        }
        .scroll-hidden::-webkit-scrollbar { display: none; }
        .scroll-hidden { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body
    class="bg-slate-100 text-slate-800 font-sans min-h-screen lg:h-full lg:overflow-hidden flex flex-col transition-colors duration-300"
    :class="{ 'queue-dark': darkMode }"
    x-data="queueBoard()"
    x-init="initBoard()"
>

    <header class="bg-[#0038a8] text-white shadow-md z-10 flex-shrink-0 relative">
        <div class="px-4 py-3 md:px-6 md:py-4 flex flex-col md:flex-row gap-3 md:gap-0 justify-between items-center">
            <div class="flex items-center gap-3 md:gap-4 text-center md:text-left">
                <div class="w-8 h-8 md:w-10 md:h-10 bg-white rounded-lg flex items-center justify-center shadow-md flex-shrink-0 mx-auto md:mx-0">
                    <svg
                        class="dswd-logo-svg"
                        viewBox="0 0 177.58324 192.76212"
                        version="1.1"
                        id="svg8">
                        <g
                        id="layer1"
                        transform="translate(-5.1854501,-26.571163)">
                        <path
                            id="rect3046"
                            style="color:#000000;fill:#ffffff;fill-opacity:1;stroke:#fcd116;stroke-width:4.4979167;stroke-linejoin:miter;stroke-miterlimit:4;stroke-dasharray:none;stroke-opacity:1"
                            d="m 51.956418,49.456777 h 83.563352 24.69356 v 95.440503 c 0,13.68028 -11.01328,24.69356 -24.69356,24.69356 H 51.956418 C 38.276137,169.58819 27.262856,158.57623 27.262856,144.89728 V 49.456777 Z" />
                        <path
                            style="fill:#0038a8;fill-opacity:1;stroke-width:0.26458332"
                            id="path2987"
                            d="m 45.027775,60.820631 v 31.797625 l 45.005624,36.967584 v 29.56189 H 62.18865 V 140.27897 L 37.060906,117.26552 V 60.808725 Z" />
                        <path
                            style="fill:#0038a8;fill-opacity:1;stroke-width:0.26458332"
                            id="path2987-7"
                            d="M 142.44656,60.820631 V 92.618256 L 97.440939,129.58584 v 29.56189 h 27.844751 v -18.86876 l 25.12774,-23.01345 V 60.808725 Z" />
                        <path
                            style="fill:#ce1126;fill-opacity:1;stroke-width:0.26458332"
                            id="path3025-4"
                            d="M 50.584025,88.924673 V 63.821535 c 0,-1.79406 1.313127,-2.507853 2.507853,-2.507853 h 32.453791 l 8.192294,7.054057 8.192297,-7.054057 h 32.45379 c 1.19472,0 2.50785,0.713793 2.50785,2.507853 V 88.924673 L 93.73836,122.70403 Z" />
                        <g
                            aria-label="DSWD"
                            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-size:38.79579163px;line-height:1.25;font-family:'Square721 BdEx BT';-inkscape-font-specification:'Square721 BdEx BT Bold';font-variant-ligatures:normal;font-variant-caps:normal;font-variant-numeric:normal;font-feature-settings:normal;text-align:center;letter-spacing:4.84947395px;writing-mode:lr-tb;text-anchor:middle;opacity:1;fill:#0038a8;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:1;stroke-linecap:square;stroke-linejoin:bevel;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1"
                            id="text845">
                            <path
                            d="m 35.121142,203.32779 h 4.603212 q 3.997027,0 5.777694,-2.08376 1.799609,-2.1027 1.799609,-6.80063 0,-4.67898 -1.667007,-6.8764 -1.667006,-2.19742 -5.209395,-2.19742 h -5.304113 z m -5.626147,5.03891 v -27.90342 h 10.93026 q 6.421764,0 9.566345,3.46662 3.163524,3.46661 3.163524,10.5135 0,3.82654 -1.174482,6.7438 -1.155539,2.91727 -3.3719,4.69793 -1.667007,1.32603 -3.788652,1.91327 -2.121645,0.5683 -5.948183,0.5683 z"
                            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-family:'Swis721 BT';-inkscape-font-specification:'Swis721 BT Bold';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1"
                            id="path1002" />
                            <path
                            d="m 61.243894,199.74752 h 5.664034 q 0.322035,2.29213 1.875383,3.40978 1.553347,1.09871 4.489552,1.09871 2.50051,0 3.769708,-0.89033 1.269198,-0.89033 1.269198,-2.63311 0,-2.5384 -7.293154,-4.20541 -0.09472,-0.0189 -0.170489,-0.0379 -0.189433,-0.0379 -0.587241,-0.13261 -3.902311,-0.85244 -5.569318,-1.91327 -1.477574,-0.94716 -2.254248,-2.53839 -0.776673,-1.61018 -0.776673,-3.78865 0,-4.0728 2.765715,-6.23233 2.765716,-2.17848 7.994055,-2.17848 4.887361,0 7.634133,2.31108 2.765716,2.31108 2.917262,6.51648 h -5.512488 q -0.151546,-2.02693 -1.553348,-3.08775 -1.401801,-1.06082 -3.997027,-1.06082 -2.254248,0 -3.485559,0.89033 -1.212369,0.87139 -1.212369,2.50051 0,2.21636 4.754758,3.31507 1.288141,0.30309 2.007985,0.47358 3.049865,0.77667 4.319063,1.21237 1.288141,0.43569 2.235304,0.9661 1.704894,0.94717 2.55734,2.51946 0.852447,1.55334 0.852447,3.73182 0,4.35695 -2.936205,6.76274 -2.936205,2.38685 -8.278204,2.38685 -5.266225,0 -8.25926,-2.44368 -2.993035,-2.44368 -3.220354,-6.95217 z"
                            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-family:'Swis721 BT';-inkscape-font-specification:'Swis721 BT Bold';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1"
                            id="path1004" />
                            <path
                            d="m 98.713658,208.3667 -7.994054,-27.90342 h 5.948183 l 4.773703,19.68205 4.03491,-19.68205 h 6.11867 l 4.03492,19.68205 4.7737,-19.68205 h 5.89135 l -7.97511,27.90342 h -5.4746 l -4.31906,-21.368 -4.33801,21.368 z"
                            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-family:'Swis721 BT';-inkscape-font-specification:'Swis721 BT Bold';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1"
                            id="path1006" />
                            <path
                            d="m 139.99102,203.32779 h 4.60321 q 3.99702,0 5.77769,-2.08376 1.79961,-2.1027 1.79961,-6.80063 0,-4.67898 -1.66701,-6.8764 -1.667,-2.19742 -5.20939,-2.19742 h -5.30411 z m -5.62615,5.03891 v -27.90342 h 10.93026 q 6.42176,0 9.56634,3.46662 3.16353,3.46661 3.16353,10.5135 0,3.82654 -1.17449,6.7438 -1.15553,2.91727 -3.3719,4.69793 -1.667,1.32603 -3.78865,1.91327 -2.12164,0.5683 -5.94818,0.5683 z"
                            style="font-style:normal;font-variant:normal;font-weight:bold;font-stretch:normal;font-family:'Swis721 BT';-inkscape-font-specification:'Swis721 BT Bold';letter-spacing:4.84947395px;fill:#0038a8;fill-opacity:1;stroke:none;stroke-width:1;stroke-miterlimit:4;stroke-opacity:1"
                            id="path1008" />
                        </g>
                        </g>
                    </svg>
                </div>
                <div>
                    <h1 class="text-sm sm:text-base md:text-xl font-extrabold tracking-tight" x-text="t('dept_name')"></h1>
                    <p class="text-[9px] md:text-xs font-bold text-slate-200 uppercase tracking-wider leading-none mt-1" x-text="t('system_subtitle')"></p>
                </div>
            </div>

            {{-- Controls — DESKTOP/TV LANG --}}
            <div class="hidden lg:flex items-center gap-3 md:gap-4 justify-between w-full md:w-auto border-t border-white/10 pt-2.5 md:pt-0 md:border-t-0">
                {{-- <div class="flex items-center bg-white/10 rounded-lg p-0.5 md:p-1">
                    <button @click="toggleSound()"
                            class="px-2 py-1 md:px-3 md:py-1.5 rounded text-[10px] md:text-xs font-bold transition-all flex items-center gap-1 md:gap-1.5"
                            :class="soundEnabled ? 'bg-white text-[#0038a8] shadow-sm' : 'text-white hover:bg-white/10'">
                        <span x-text="soundEnabled ? '🔈 Chime ON' : '🔇 Chime OFF'"></span>
                    </button>
                    <button @click="toggleVoice()"
                            class="px-2 py-1 md:px-3 md:py-1.5 rounded text-[10px] md:text-xs font-bold transition-all flex items-center gap-1 md:gap-1.5 ml-1"
                            :class="voiceEnabled ? 'bg-white text-[#0038a8] shadow-sm' : 'text-white hover:bg-white/10'">
                        <span x-text="voiceEnabled ? '🗣️ Voice ON' : '🤐 Voice OFF'"></span>
                    </button>
                </div> --}}

                <div class="flex items-center gap-3">
                    <button
                        @click="toggleDarkMode()"
                        class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition-all text-white text-[10px] md:text-xs font-black uppercase tracking-wide flex items-center gap-1.5"
                        type="button"
                    >
                        <span x-text="darkMode ? '☀️ Light' : '🌙 Dark'"></span>
                    </button>
                    <button @click="toggleLanguage()" class="px-3 py-1.5 rounded-lg bg-white/10 hover:bg-white/20 transition-all text-white text-[10px] md:text-xs font-black uppercase tracking-wide flex items-center gap-1.5">
                        <span x-text="language === 'en' ? '🇵🇭 Tagalog' : '🇬🇧 English'"></span>
                    </button>

                    <button @click="toggleFullscreen()"
                            class="p-1.5 md:p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all text-white flex items-center justify-center">
                        <svg class="w-3.5 h-3.5 md:w-4 md:h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75v4.5m0-4.5h-4.5m4.5 0L15 9m5.25 11.25v-4.5m0 4.5h-4.5m4.5 0l-5.25-5.25" />
                        </svg>
                    </button>
                    <div class="pl-3 border-l border-white/20 text-right">
                        <p class="text-base sm:text-lg md:text-2xl font-black tracking-tight text-white leading-none" x-text="timeString"></p>
                        <p class="text-[25px] sm:text-xs md:text-sm font-bold text-slate-200 uppercase tracking-widest mt-1" x-text="dateString"></p>
                    </div>
                </div>
            </div>

            {{-- Clock + darkmode + Language — MOBILE --}}
           <div class="text-right flex-shrink-0 lg:hidden flex items-center gap-2">
                <button
                    @click="toggleDarkMode()"
                    class="px-2 py-1 rounded bg-white/10 hover:bg-white/20 text-white text-[9px] font-black uppercase transition-all"
                    type="button"
                >
                    <span x-text="darkMode ? '☀️' : '🌙'"></span>
                </button>

                <button
                    @click="toggleLanguage()"
                    class="px-2 py-1 rounded bg-white/10 hover:bg-white/20 text-white text-[9px] font-black uppercase transition-all"
                >
                    <span x-text="language === 'en' ? 'TL' : 'EN'"></span>
                </button>

                <div>
                    <p class="text-xs sm:text-sm font-bold tracking-tight text-white leading-none" x-text="timeString"></p>
                    <p class="text-[8px] font-semibold text-slate-200 uppercase tracking-widest mt-1" x-text="dateString"></p>
                </div>
            </div>
        </div>

        <div class="h-1.5 w-full flex">
            <div class="bg-[#0038a8] w-1/2"></div>
            <div class="bg-[#fcd116] w-12"></div>
            <div class="bg-[#ce1126] w-1/2"></div>
        </div>
    </header>

    <main class="flex-1 p-4 md:p-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-5 overflow-y-auto scroll-hidden">
        <template x-for="deskKey in ['validation', 'assessment', 'review', 'releasing']" :key="deskKey">

            <div
                class="bg-white rounded-2xl shadow-md border border-slate-200 flex flex-col overflow-hidden transition-all duration-300"
                :class="[getDeskBorderClass(deskKey), { 'flash-card': flashDesk === deskKey }]"
            >

                {{-- COUNTER HEADER --}}
                <div class="p-4 flex justify-between items-center border-b border-slate-100 flex-shrink-0">

                    <div class="flex items-center gap-2">
                        <span
                            class="text-[9px] font-black tracking-wider px-2 py-1 rounded uppercase shadow-sm"
                            :class="[
                                getDeskBadgeColor(deskKey),
                                deskKey === 'assessment'
                                    ? 'text-[#854d0e]'
                                    : 'text-white'
                            ]"
                            x-text="desks[deskKey].counter"
                        ></span>
                    </div>

                    <span class="text-[9px] font-black tracking-wider uppercase text-slate-400" x-text="translateDeskLabel(desks[deskKey].label)"></span>

                </div>


                {{-- TWO LANES --}}
                <div class="grid grid-cols-2 min-h-[420px]">

                    {{-- ============================================ --}}
                    {{-- REGULAR LANE --}}
                    {{-- ============================================ --}}
                    <template x-for="laneKey in ['regular', 'priority']" :key="laneKey">

                        <div
                            class="flex flex-col min-w-0"
                            :class="laneKey === 'priority'
                                ? 'border-l border-slate-200 bg-red-50/20'
                                : 'bg-white'"
                        >

                            {{-- LANE HEADER --}}
                            <div
                                class="px-4 py-3 border-b border-slate-100"
                                :class="laneKey === 'priority'
                                    ? 'bg-red-50'
                                    : 'bg-slate-50'"
                            >

                                <div class="flex items-center justify-center gap-2">

                                    <span
                                        class="w-2 h-2 rounded-full"
                                        :class="laneKey === 'priority'
                                            ? 'bg-red-600'
                                            : 'bg-slate-500'"
                                    ></span>

                                    <span class="text-[10px] font-black uppercase tracking-widest" :class="laneKey === 'priority' ? 'text-red-700' : 'text-slate-600'" x-text="laneKey === 'priority' ? t('priority') : t('regular')"></span>

                                </div>

                            </div>


                            {{-- MAIN QUEUE DISPLAY --}}
                            <div class="p-4 border-b border-slate-100 min-h-[190px] flex flex-col items-center justify-center">

                                {{-- VALIDATION = NOW SERVING --}}
                                <template x-if="deskKey === 'validation'">

                                    <div class="text-center w-full">

                                        <div class="flex items-center justify-center gap-1.5 mb-2">

                                            <span
                                                class="w-2 h-2 rounded-full animate-ping"
                                                :class="laneKey === 'priority'
                                                    ? 'bg-red-600'
                                                    : 'bg-slate-500'"
                                            ></span>

                                            <span class="text-[9px] font-black tracking-widest uppercase" :class="laneKey === 'priority' ? 'text-red-600' : 'text-slate-600'" x-text="t('now_serving')"></span>

                                        </div>


                                        <template x-if="getLane(deskKey, laneKey).serving.length > 0">

                                            <div>

                                                <div class="text-3xl lg:text-4xl xl:text-5xl font-black tracking-tight text-slate-900 font-mono select-none">
                                                    <span x-text="getLane(deskKey, laneKey).serving[0].queue_number"></span>
                                                </div>

                                                <div class="mt-3 flex flex-col items-center justify-center gap-2">
                                                    <span
                                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider"
                                                        :class="getCategoryClass(getLane(deskKey, laneKey).serving[0].client_category)"
                                                        x-text="getLane(deskKey, laneKey).serving[0].client_category"
                                                    ></span>

                                                    <div class="flex flex-wrap items-center justify-center gap-2">

                                                        <template x-if="getLane(deskKey, laneKey).serving[0].is_returnee">
                                                            <span class="rounded-full border border-orange-200 bg-orange-100 px-2.5 py-1 text-[9px] font-black uppercase tracking-wide text-orange-700"
                                                                  x-text="t('returnee')"></span>
                                                        </template>

                                                        <span class="rounded-full px-2.5 py-1 text-[9px] font-black uppercase tracking-wide" :class="laneKey === 'priority' ? 'border border-red-200 bg-red-100 text-red-700' : 'border border-slate-200 bg-slate-100 text-slate-600'" x-text="laneKey === 'priority' ? t('priority') : t('regular')"></span>

                                                    </div>

                                                </div>

                                            </div>

                                        </template>


                                        <template x-if="getLane(deskKey, laneKey).serving.length === 0">

                                            <div class="text-slate-400 font-extrabold text-[10px] uppercase tracking-wider py-4" x-text="t('no_active_ticket')"></div>

                                        </template>

                                    </div>

                                </template>


                                {{-- OTHER DESKS = NEXT IN LINE --}}
                                <template x-if="deskKey !== 'validation'">

                                    <div class="text-center w-full">

                                        <div class="flex items-center justify-center gap-1.5 mb-2">

                                            <span
                                                class="w-2 h-2 rounded-full animate-pulse"
                                                :class="laneKey === 'priority'
                                                    ? 'bg-red-500'
                                                    : 'bg-amber-500'"
                                            ></span>

                                            <span class="text-[9px] font-black tracking-widest uppercase" :class="laneKey === 'priority' ? 'text-red-600' : 'text-amber-600'" x-text="t('next_in_line')"></span>

                                        </div>


                                        <template x-if="getLane(deskKey, laneKey).upNext.length > 0">

                                            <div>

                                                <div class="text-4xl md:text-5xl font-black tracking-tight text-slate-700 font-mono select-none">
                                                    <span x-text="getLane(deskKey, laneKey).upNext[0].queue_number"></span>
                                                </div>

                                                <div class="mt-3 flex flex-col items-center justify-center gap-2">

                                                    <span
                                                        class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-wider"
                                                        :class="getCategoryClass(getLane(deskKey, laneKey).upNext[0].client_category)"
                                                        x-text="getLane(deskKey, laneKey).upNext[0].client_category"
                                                    ></span>

                                                    <span class="rounded-full px-2.5 py-1 text-[9px] font-black uppercase tracking-wide" :class="laneKey === 'priority' ? 'border border-red-200 bg-red-100 text-red-700' : 'border border-slate-200 bg-slate-100 text-slate-600'" x-text="laneKey === 'priority' ? t('priority') : t('regular')"></span>

                                                </div>

                                            </div>

                                        </template>


                                        <template x-if="getLane(deskKey, laneKey).upNext.length === 0">

                                            <div class="text-slate-400 font-extrabold text-[10px] uppercase tracking-wider py-4" x-text="t('no_active_ticket')"></div>

                                        </template>

                                    </div>

                                </template>

                            </div>


                            {{-- WAITING LIST --}}
                            <div class="p-3 flex-1 overflow-y-auto scroll-hidden space-y-2 min-h-[220px]">

                                <div class="flex items-center justify-between mb-2">

                                    <p class="text-[9px] font-black text-slate-400 uppercase tracking-wider" x-text="t('waiting')"></p>

                                    <span class="text-[8px] font-black uppercase tracking-wider" :class="laneKey === 'priority' ? 'text-red-400' : 'text-slate-400'" x-text="laneKey === 'priority' ? t('priority_lane') : t('regular_lane')"></span>

                                </div>


                                <template
                                    x-for="item in getWaitingItems(deskKey, laneKey)"
                                    :key="item.queue_id"
                                >

                                    <div
                                        class="rounded-lg p-2.5 border flex justify-between items-center transition-all"
                                        :class="item.is_on_hold
                                            ? 'bg-amber-50 border-amber-200'
                                            : laneKey === 'priority'
                                                ? 'bg-red-50/50 border-red-100'
                                                : 'bg-slate-50 border-slate-200/60'"
                                    >

                                        <div class="flex items-center gap-1.5 min-w-0">

                                            <span
                                                class="font-mono text-sm font-bold text-slate-700"
                                                x-text="item.queue_number"
                                            ></span>


                                            {{-- ON HOLD --}}
                                            <template x-if="item.is_on_hold">

                                                <span class="rounded-full bg-amber-100 px-2 py-1 text-[8px] font-extrabold uppercase text-amber-700 border border-amber-200" x-text="t('on_hold')"></span>

                                            </template>


                                            {{-- RETURNEE --}}
                                            <template x-if="!item.is_on_hold && item.is_returnee">

                                                <span class="rounded-full bg-orange-100 px-2 py-1 text-[8px] font-extrabold uppercase text-orange-700" x-text="t('returnee')"></span>

                                            </template>

                                        </div>


                                        <span
                                            class="text-[8px] font-bold uppercase text-slate-400 text-right ml-2"
                                            x-text="item.client_category"
                                        ></span>

                                    </div>

                                </template>


                                <template x-if="getWaitingItems(deskKey, laneKey).length === 0">

                                    <div class="text-center py-6">

                                        <span class="text-[9px] font-bold text-slate-300 uppercase tracking-widest" x-text="t('no_waiting_ticket')"></span>

                                    </div>

                                </template>

                            </div>

                        </div>

                    </template>

                </div>

            </div>

        </template>

    </main>

    <footer class="h-1 w-full flex flex-shrink-0">
        <div class="bg-[#0038a8] flex-1"></div>
        <div class="bg-[#fcd116] w-12"></div>
        <div class="bg-[#ce1126] flex-1"></div>
    </footer>

    <script>
        function queueBoard() {
            return {
                desks: {
                    validation: {
                        label: '',
                        counter: '',
                        regular: { serving: [], upNext: [], onHold: [] },
                        priority: { serving: [], upNext: [], onHold: [] },
                    },

                    assessment: {
                        label: '',
                        counter: '',
                        regular: { serving: [], upNext: [], onHold: [] },
                        priority: { serving: [], upNext: [], onHold: [] },
                    },

                    review: {
                        label: '',
                        counter: '',
                        regular: { serving: [], upNext: [], onHold: [] },
                        priority: { serving: [], upNext: [], onHold: [] },
                    },

                    releasing: {
                        label: '',
                        counter: '',
                        regular: { serving: [], upNext: [], onHold: [] },
                        priority: { serving: [], upNext: [], onHold: [] },
                    },
                },

                audioCtx: null,
                isKioskDisplay: false,
                lastValidationQueueIds: {
                    regular: null,
                    priority: null,
                },
                allKnownNumbers: new Set(),
                flashDesk: null,

                soundEnabled: true,
                voiceEnabled: true,

                language: 'en',
                darkMode: false,
                translations: {
                    en: { dept_name: 'DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT', system_subtitle: 'AICS Queue Management System • Live Monitor', now_serving: 'NOW SERVING', next_in_line: 'NEXT IN LINE', no_active_ticket: 'No Active Ticket', waiting: 'Waiting', priority_lane: 'Priority Lane', regular_lane: 'Regular Lane', no_waiting_ticket: 'No Waiting Ticket', on_hold: 'ON HOLD', returnee: 'RETURNEE', priority: 'PRIORITY', regular: 'REGULAR' },
                    tl: { dept_name: 'KAGAWARAN NG KAGALINGANG PANLIPUNAN AT PAGPAPAUNLAD', system_subtitle: 'Sistema ng Pila ng AICS • Live na Pagmamanman', now_serving: 'KASALUKUYANG SINISILBIHAN', next_in_line: 'SUSUNOD SA PILA', no_active_ticket: 'Walang Aktibong Tiket', waiting: 'Naghihintay', priority_lane: 'Linyang Priyoridad', regular_lane: 'Regular na Linya', no_waiting_ticket: 'Walang Naghihintay na Tiket', on_hold: 'NAKA-HOLD', returnee: 'BUMALIK', priority: 'PRIYORIDAD', regular: 'REGULAR' }
                },
                deskLabelMap: { 'DOCUMENT VALIDATION': 'PAGPAPATUNAY NG DOKUMENTO', 'INTERVIEW & ASSESSMENT': 'PANAYAM AT PAGTATASA', 'OFFICER REVIEW': 'PAGSUSURI NG OPISYAL', 'ASSISTANCE RELEASING': 'PAGBIBIGAY NG TULONG' },

                timeString: '',
                dateString: '',

                initBoard() {
                    this.language = localStorage.getItem('queue_board_language') || 'en';

                    this.darkMode = localStorage.getItem('queue_board_dark_mode') === 'true';

                    this.updateClock();
                    setInterval(() => this.updateClock(), 1000);

                    this.isKioskDisplay = window.innerWidth >= 1024;

                    this.soundEnabled = localStorage.getItem('queue_board_sound') !== 'false';
                    this.voiceEnabled = localStorage.getItem('queue_board_voice') !== 'false';

                    if (this.isKioskDisplay) {
                        try {
                            this.audioCtx = new (window.AudioContext || window.webkitAudioContext)();
                            if (this.audioCtx.state === 'suspended') {
                                this.audioCtx.resume();
                            }
                        } catch (e) {
                            console.error('Audio init failed:', e);
                        }
                    }

                    this.fetchQueueData(true);

                    window.Echo.channel('public-queue-board')
                        .listen('.dashboard.updated', () => {
                            this.fetchQueueData(false);
                        });
                },

                fetchQueueData(isFirstLoad = false) {
                    fetch("{{ route('public.public-queue.data') }}")
                        .then(res => res.json())
                        .then(data => {
                            if (!isFirstLoad) {
                                this.detectChangesAndNotify(data.desks);
                            } else {
                                Object.keys(data.desks).forEach(deskKey => {

                                    ['regular', 'priority'].forEach(laneKey => {

                                        const lane = data.desks[deskKey][laneKey];

                                        [
                                            ...(lane.serving || []),
                                            ...(lane.upNext || []),
                                            ...(lane.onHold || [])
                                        ].forEach(item => {

                                            this.allKnownNumbers.add(
                                                deskKey + ':' + laneKey + ':' + item.queue_id
                                            );

                                        });

                                    });

                                });

                                this.lastValidationQueueIds = {
                                    regular: data.desks.validation.regular.serving[0]?.queue_id ?? null,
                                    priority: data.desks.validation.priority.serving[0]?.queue_id ?? null,
                                };
                            }

                            this.desks = data.desks;
                        })
                        .catch(err => console.error('Failed to fetch queue data:', err));
                },

                detectChangesAndNotify(newDesks) {
                    if (!this.isKioskDisplay) return;

                    let hasNewEntry = false;
                    let validationChanged = false;
                    let changedValidationItem = null;

                    Object.keys(newDesks).forEach(deskKey => {

                        ['regular', 'priority'].forEach(laneKey => {

                            const lane = newDesks[deskKey][laneKey];

                            const allItems = [
                                ...(lane.serving || []),
                                ...(lane.upNext || []),
                                ...(lane.onHold || [])
                            ];

                            allItems.forEach(item => {

                                const key =
                                    deskKey + ':' +
                                    laneKey + ':' +
                                    item.queue_id;

                                if (!this.allKnownNumbers.has(key)) {
                                    this.allKnownNumbers.add(key);
                                    hasNewEntry = true;
                                }

                            });

                        });

                    });


                    /*
                    |--------------------------------------------------------------------------
                    | Validation lane changes
                    |--------------------------------------------------------------------------
                    */
                    ['regular', 'priority'].forEach(laneKey => {

                        const newQueueId =
                            newDesks.validation[laneKey].serving[0]?.queue_id ?? null;

                        if (
                            newQueueId &&
                            newQueueId !== this.lastValidationQueueIds[laneKey]
                        ) {

                            validationChanged = true;

                            changedValidationItem =
                                newDesks.validation[laneKey].serving[0];

                            this.lastValidationQueueIds[laneKey] = newQueueId;

                        }

                    });


                    if (validationChanged) {

                        this.flashDesk = 'validation';

                        setTimeout(() => {
                            this.flashDesk = null;
                        }, 4000);

                        if (this.soundEnabled) {
                            this.playChimeTone();
                        }

                        if (this.voiceEnabled && changedValidationItem) {

                            setTimeout(() => {

                                const newValidationNumber =
                                    changedValidationItem.queue_number;

                                const ticketPart =
                                    newValidationNumber.split('-')[1] ||
                                    newValidationNumber;

                                const readableNo =
                                    ticketPart.replace(/^0+/, '') || '0';

                                const counterText =
                                    changedValidationItem.priority
                                        ? (
                                            this.language === 'tl'
                                                ? 'Priyoridad na Pagpapatunay ng Dokumento, Counter 1'
                                                : 'Priority Document Validation, Counter 1'
                                        )
                                        : (
                                            this.language === 'tl'
                                                ? 'Pagpapatunay ng Dokumento, Counter 1'
                                                : 'Document Validation, Counter 1'
                                        );

                                const phrase =
                                    this.language === 'tl'
                                        ? `Numero ng pila, ${ticketPart}, mangyaring pumunta sa, ${counterText}. Numero, ${readableNo}.`
                                        : `Queue number, ${ticketPart}, please proceed to, ${counterText}. Number, ${readableNo}.`;

                                this.announceText(phrase);

                            }, 800);
                        }

                    } else if (hasNewEntry && this.soundEnabled) {

                        this.playChimeTone();

                    }
                },

                getLane(deskKey, laneKey) {
                    return this.desks?.[deskKey]?.[laneKey] ?? {
                        serving: [],
                        upNext: [],
                        onHold: []
                    };
                },

                getWaitingItems(deskKey, laneKey) {
                    const lane = this.getLane(deskKey, laneKey);

                    if (!lane) return [];

                    return [
                        ...(lane.upNext || []).slice(deskKey === 'validation' ? 0 : 1),
                        ...(lane.onHold || [])
                    ];
                },
                updateClock() {
                    const now = new Date();
                    this.timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                    if (this.language === 'tl') {
                        const days = ['Linggo', 'Lunes', 'Martes', 'Miyerkules', 'Huwebes', 'Biyernes', 'Sabado'];
                        const months = ['Enero', 'Pebrero', 'Marso', 'Abril', 'Mayo', 'Hunyo', 'Hulyo', 'Agosto', 'Setyembre', 'Oktubre', 'Nobyembre', 'Disyembre'];
                        this.dateString = `${days[now.getDay()]}, ${months[now.getMonth()]} ${now.getDate()}, ${now.getFullYear()}`;
                    } else {
                        this.dateString = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
                    }
                },

                t(key) {
                    return this.translations[this.language]?.[key] ?? key;
                },

                translateDeskLabel(label) {
                    if (this.language === 'en') return label;
                    const normalizedLabel = String(label || '').trim().toUpperCase();
                    return this.deskLabelMap[normalizedLabel] ?? label;
                },

                toggleDarkMode() {
                    this.darkMode = !this.darkMode;

                    localStorage.setItem(
                        'queue_board_dark_mode',
                        this.darkMode
                    );
                },

                toggleLanguage() {
                    this.language = this.language === 'en' ? 'tl' : 'en';
                    localStorage.setItem('queue_board_language', this.language);
                    this.updateClock();
                },

                toggleSound() {
                    this.soundEnabled = !this.soundEnabled;
                    localStorage.setItem('queue_board_sound', this.soundEnabled);
                    if (this.soundEnabled) this.playChimeTone();
                },

                toggleVoice() {
                    this.voiceEnabled = !this.voiceEnabled;
                    localStorage.setItem('queue_board_voice', this.voiceEnabled);
                    if (this.voiceEnabled) this.announceText('Voice announcement activated');
                },

                toggleFullscreen() {
                    if (!document.fullscreenElement) {
                        document.documentElement.requestFullscreen().catch(err => console.error(err.message));
                    } else {
                        document.exitFullscreen();
                    }
                },

                getCategoryClass(category) {
                    switch (category) {
                        case 'Senior Citizens':
                            return 'bg-blue-100 text-[#1d4ed8] border border-blue-200';

                        case 'Family heads and Other Needy Adult':
                            return 'bg-emerald-100 text-emerald-800 border border-emerald-200';

                        case 'Youth in Need and Other Needy Adult':
                            return 'bg-purple-100 text-purple-800 border border-purple-200';

                        case 'Youth in Need of Special Protection':
                            return 'bg-red-100 text-red-800 border border-red-200';

                        case 'Men/Women in specially difficult circumstances':
                            return 'bg-orange-100 text-orange-800 border border-orange-200';

                        default:
                            return 'bg-slate-100 text-slate-600 border border-slate-200';
                    }   
                },

               getDeskBadgeColor(deskKey) {
                    switch (deskKey) {
                        case 'validation':
                            return 'bg-[#0038a8]';

                        case 'assessment':
                            return 'bg-[#fcd116]';

                        case 'review':
                            return 'bg-[#ce1126]';

                        case 'releasing':
                            return 'bg-emerald-600';

                        default:
                            return 'bg-slate-500';
                    }
                },

                getDeskBorderClass(deskKey) {
                    switch (deskKey) {
                        case 'validation':
                            return 'border-t-[6px] border-t-[#0038a8]';

                        case 'assessment':
                            return 'border-t-[6px] border-t-[#fcd116]';

                        case 'review':
                            return 'border-t-[6px] border-t-[#ce1126]';

                        case 'releasing':
                            return 'border-t-[6px] border-t-emerald-600';

                        default:
                            return '';
                    }
                },

                playChimeTone() {
                    if (!this.audioCtx) return;
                    try {
                        if (this.audioCtx.state === 'suspended') this.audioCtx.resume();

                        const osc1 = this.audioCtx.createOscillator();
                        const gain1 = this.audioCtx.createGain();
                        osc1.type = 'sine';
                        osc1.frequency.setValueAtTime(523.25, this.audioCtx.currentTime);
                        gain1.gain.setValueAtTime(0.12, this.audioCtx.currentTime);
                        gain1.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 0.8);

                        const osc2 = this.audioCtx.createOscillator();
                        const gain2 = this.audioCtx.createGain();
                        osc2.type = 'sine';
                        osc2.frequency.setValueAtTime(659.25, this.audioCtx.currentTime + 0.12);
                        gain2.gain.setValueAtTime(0.12, this.audioCtx.currentTime + 0.12);
                        gain2.gain.exponentialRampToValueAtTime(0.001, this.audioCtx.currentTime + 1.0);

                        osc1.connect(gain1); gain1.connect(this.audioCtx.destination);
                        osc2.connect(gain2); gain2.connect(this.audioCtx.destination);

                        osc1.start(this.audioCtx.currentTime); osc1.stop(this.audioCtx.currentTime + 0.8);
                        osc2.start(this.audioCtx.currentTime + 0.12); osc2.stop(this.audioCtx.currentTime + 1.0);
                    } catch (e) {
                        console.error('Chime playback failed:', e);
                    }
                },

                announceText(text) {
                    if ('speechSynthesis' in window) {
                        window.speechSynthesis.cancel();
                        const utterance = new SpeechSynthesisUtterance(text);
                        utterance.rate = 0.9;
                        utterance.pitch = 1.0;
                        utterance.volume = 1.0;

                        const voices = window.speechSynthesis.getVoices();
                        let defaultVoice;

                        if (this.language === 'tl') {
                            defaultVoice =
                                voices.find(v => /^fil(-|_)/i.test(v.lang)) ||
                                voices.find(v => /filipino|tagalog/i.test(v.name));
                        }

                        if (!defaultVoice) {
                            defaultVoice =
                                voices.find(v => v.lang.includes('PH') || v.lang.includes('en-PH'));
                        }

                        if (!defaultVoice) {
                            defaultVoice = voices.find(v => v.lang.includes('en-US')) || voices[0];
                        }

                        if (defaultVoice) {
                            utterance.voice = defaultVoice;
                        }

                        utterance.lang = this.language === 'tl' ? 'fil-PH' : 'en-PH';

                        window.speechSynthesis.speak(utterance);
                    }
                }
            };
        }
    </script>
</body>
</html>