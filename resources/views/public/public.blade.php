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
<body class="bg-slate-100 text-slate-800 font-sans min-h-screen flex flex-col"
      x-data="queueBoard()"
      x-init="initBoard()">

    <header class="bg-[#0038a8] text-white shadow-md z-10 flex-shrink-0 relative">
        <div class="px-3 py-2.5 sm:px-4 sm:py-3 md:px-6 md:py-4 flex flex-col lg:flex-row gap-2 lg:gap-0 justify-between items-center">

            <div class="flex items-center gap-2 sm:gap-3 md:gap-4 min-w-0 w-full lg:w-auto">
                <div class="w-7 h-7 sm:w-8 sm:h-8 md:w-10 md:h-10 bg-white rounded-lg flex items-center justify-center shadow-md flex-shrink-0">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 md:w-7 md:h-7 text-[#0038a8]" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 17h-2v-2h2v2zm2.07-7.75l-.9.92C13.45 12.9 13 13.5 13 15h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                    </svg>
                </div>
                <div class="min-w-0">
                    <h1 class="text-[11px] sm:text-sm md:text-xl font-extrabold tracking-tight leading-tight truncate">
                        DEPARTMENT OF SOCIAL WELFARE AND DEVELOPMENT
                    </h1>
                    <p class="text-[8px] sm:text-[9px] md:text-xs font-bold text-slate-200 uppercase tracking-wider leading-none mt-0.5 sm:mt-1 truncate">
                        AICS Queue Management System • Live Monitor
                    </p>
                </div>
            </div>

            {{-- Controls — DESKTOP/TV LANG (lg at pataas) --}}
            <div class="hidden lg:flex items-center gap-4 justify-between w-full md:w-auto border-t border-white/10 pt-2.5 md:pt-0 md:border-t-0">
                <div class="flex items-center bg-white/10 rounded-lg p-1">
                    <button @click="toggleSound()"
                            class="px-3 py-1.5 rounded text-xs font-bold transition-all flex items-center gap-1.5"
                            :class="soundEnabled ? 'bg-white text-[#0038a8] shadow-sm' : 'text-white hover:bg-white/10'">
                        <span x-text="soundEnabled ? '🔈 Chime ON' : '🔇 Chime OFF'"></span>
                    </button>
                    <button @click="toggleVoice()"
                            class="px-3 py-1.5 rounded text-xs font-bold transition-all flex items-center gap-1.5 ml-1"
                            :class="voiceEnabled ? 'bg-white text-[#0038a8] shadow-sm' : 'text-white hover:bg-white/10'">
                        <span x-text="voiceEnabled ? '🗣️ Voice ON' : '🤐 Voice OFF'"></span>
                    </button>
                </div>

                <div class="flex items-center gap-3">
                    <button @click="toggleFullscreen()"
                            class="p-2 rounded-lg bg-white/10 hover:bg-white/20 transition-all text-white flex items-center justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 3.75v4.5m0-4.5h4.5m-4.5 0L9 9M3.75 20.25v-4.5m0 4.5h4.5m-4.5 0L9 15M20.25 3.75v4.5m0-4.5h-4.5m4.5 0L15 9m5.25 11.25v-4.5m0 4.5h-4.5m4.5 0l-5.25-5.25" />
                        </svg>
                    </button>

                    <div class="pl-3 border-l border-white/20 text-right">
                        <p class="text-xs sm:text-sm md:text-md font-bold tracking-tight text-white leading-none" x-text="timeString"></p>
                        <p class="text-[8px] md:text-[9px] font-semibold text-slate-200 uppercase tracking-widest mt-1" x-text="dateString"></p>
                    </div>
                </div>
            </div>

            {{-- Clock lang — MOBILE (wala pang lg breakpoint) --}}
            <div class="text-right flex-shrink-0 lg:hidden">
                <p class="text-xs sm:text-sm font-bold tracking-tight text-white leading-none" x-text="timeString"></p>
                <p class="text-[7px] sm:text-[8px] font-semibold text-slate-200 uppercase tracking-widest mt-1" x-text="dateString"></p>
            </div>
        </div>

        <div class="h-1.5 w-full flex">
            <div class="bg-[#0038a8] w-1/2"></div>
            <div class="bg-[#fcd116] w-12"></div>
            <div class="bg-[#ce1126] w-1/2"></div>
        </div>
    </header>

    <main class="flex-1 p-3 sm:p-4 md:p-6 grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-3 sm:gap-4 md:gap-5">
        <template x-for="deskKey in ['validation', 'assessment', 'review', 'releasing']" :key="deskKey">
            <div class="bg-white rounded-2xl shadow-md border border-slate-200 flex flex-col overflow-hidden transition-all duration-300"
                 :class="[getDeskBorderClass(deskKey), { 'flash-card': flashDesk === deskKey }]">

                <div class="p-3 sm:p-4 flex justify-between items-center border-b border-slate-100 flex-shrink-0">
                    <span class="text-white text-[9px] sm:text-[10px] font-black tracking-wider px-2 py-1 rounded uppercase shadow-sm"
                          :class="getDeskBadgeColor(deskKey)"
                          x-text="desks[deskKey].counter">
                    </span>
                    <span class="text-[9px] sm:text-[10px] font-black tracking-wider uppercase text-slate-400 text-right" x-text="desks[deskKey].label"></span>
                </div>

                <div class="p-4 sm:p-5 flex flex-col items-center justify-center border-b border-slate-100 min-h-[150px] sm:min-h-[170px]">
                    <template x-if="deskKey === 'validation'">
                        <div class="text-center w-full">
                            <div class="flex items-center justify-center gap-1.5 mb-2">
                                <span class="w-2 h-2 rounded-full bg-red-600 animate-ping"></span>
                                <span class="text-[9px] sm:text-[10px] font-black tracking-widest text-red-600 uppercase">NOW SERVING</span>
                            </div>
                            <template x-if="desks.validation.serving.length > 0">
                                <div>
                                    <div class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-slate-900 font-mono select-none break-all">
                                        <span x-text="desks.validation.serving[0].queue_number"></span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-extrabold text-slate-800 mt-2 uppercase tracking-wide" x-text="desks.validation.serving[0].masked_name"></div>
                                    <div class="mt-2 flex items-center justify-center gap-1.5 flex-wrap">
                                        <span class="px-2 py-0.5 rounded-full text-[8px] sm:text-[9px] font-black uppercase tracking-wider"
                                              :class="getCategoryClass(desks.validation.serving[0].client_category)"
                                              x-text="desks.validation.serving[0].client_category"></span>
                                        <template x-if="desks.validation.serving[0].priority">
                                            <span class="bg-red-600 text-white text-[7px] sm:text-[8px] font-black uppercase px-1.5 py-0.5 rounded-full">⚡ PRIORITY</span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            <template x-if="desks.validation.serving.length === 0">
                                <div class="text-slate-400 font-extrabold text-xs uppercase tracking-wider py-4">No Active Ticket</div>
                            </template>
                        </div>
                    </template>

                    <template x-if="deskKey !== 'validation'">
                        <div class="text-center w-full">
                            <div class="flex items-center justify-center gap-1.5 mb-2">
                                <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                                <span class="text-[9px] sm:text-[10px] font-black tracking-widest text-amber-600 uppercase">NEXT IN LINE</span>
                            </div>
                            <template x-if="desks[deskKey].upNext.length > 0">
                                <div>
                                    <div class="text-3xl sm:text-4xl md:text-5xl font-black tracking-tight text-slate-700 font-mono select-none break-all">
                                        <span x-text="desks[deskKey].upNext[0].queue_number"></span>
                                    </div>
                                    <div class="text-xs sm:text-sm font-extrabold text-slate-700 mt-2 uppercase tracking-wide" x-text="desks[deskKey].upNext[0].masked_name"></div>
                                    <div class="mt-2 flex items-center justify-center gap-1.5 flex-wrap">
                                        <span class="px-2 py-0.5 rounded-full text-[8px] sm:text-[9px] font-black uppercase tracking-wider"
                                              :class="getCategoryClass(desks[deskKey].upNext[0].client_category)"
                                              x-text="desks[deskKey].upNext[0].client_category"></span>
                                        <template x-if="desks[deskKey].upNext[0].priority">
                                            <span class="bg-red-600 text-white text-[7px] sm:text-[8px] font-black uppercase px-1.5 py-0.5 rounded-full">⚡ PRIORITY</span>
                                        </template>
                                    </div>
                                </div>
                            </template>
                            <template x-if="desks[deskKey].upNext.length === 0">
                                <div class="text-slate-400 font-extrabold text-xs uppercase tracking-wider py-4">Walang Naghihintay</div>
                            </template>
                        </div>
                    </template>
                </div>

                <div class="p-3 sm:p-4 space-y-2 max-h-[180px] sm:max-h-[220px] overflow-y-auto scroll-hidden">
                    <p class="text-[8px] sm:text-[9px] font-black text-slate-400 uppercase tracking-wider mb-2">
                        <span x-text="deskKey === 'validation' ? 'Up Next' : 'Waiting'"></span>
                    </p>

                    <template x-for="item in (deskKey === 'validation' ? desks.validation.upNext : desks[deskKey].upNext.slice(1))" :key="item.queue_number">
                        <div class="bg-slate-50 rounded-lg p-2 sm:p-2.5 border border-slate-200/60 flex justify-between items-center gap-2">
                            <div class="flex items-center gap-1.5 min-w-0">
                                <span class="font-mono text-xs sm:text-sm font-bold text-slate-700 truncate" x-text="item.queue_number"></span>
                                <template x-if="item.priority">
                                    <span class="w-1.5 h-1.5 rounded-full bg-red-500 flex-shrink-0"></span>
                                </template>
                            </div>
                            <span class="text-[8px] sm:text-[9px] font-bold uppercase text-slate-400 flex-shrink-0" x-text="item.client_category"></span>
                        </div>
                    </template>

                    <template x-if="(deskKey === 'validation' ? desks.validation.upNext : desks[deskKey].upNext.slice(1)).length === 0">
                        <div class="text-center py-4 sm:py-6">
                            <span class="text-[9px] sm:text-[10px] font-bold text-slate-300 uppercase tracking-widest">Walang Iba Pang Naghihintay</span>
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
                    validation: { label: '', counter: '', serving: [], upNext: [] },
                    assessment: { label: '', counter: '', serving: [], upNext: [] },
                    review: { label: '', counter: '', serving: [], upNext: [] },
                    releasing: { label: '', counter: '', serving: [], upNext: [] },
                },

                audioCtx: null,
                isKioskDisplay: false,
                lastValidationNumber: null,
                allKnownNumbers: new Set(),
                flashDesk: null,

                soundEnabled: true,
                voiceEnabled: true,

                timeString: '',
                dateString: '',

                initBoard() {
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
                                    [...data.desks[deskKey].serving, ...data.desks[deskKey].upNext].forEach(item => {
                                        this.allKnownNumbers.add(deskKey + ':' + item.queue_number);
                                    });
                                });
                                this.lastValidationNumber = data.desks.validation.serving[0]?.queue_number ?? null;
                            }

                            this.desks = data.desks;
                        })
                        .catch(err => console.error('Failed to fetch queue data:', err));
                },

                detectChangesAndNotify(newDesks) {
                    if (!this.isKioskDisplay) return; // Walang sound/voice sa mobile

                    let hasNewEntry = false;

                    Object.keys(newDesks).forEach(deskKey => {
                        const allItems = [...newDesks[deskKey].serving, ...newDesks[deskKey].upNext];
                        allItems.forEach(item => {
                            const key = deskKey + ':' + item.queue_number;
                            if (!this.allKnownNumbers.has(key)) {
                                this.allKnownNumbers.add(key);
                                hasNewEntry = true;
                            }
                        });
                    });

                    const newValidationNumber = newDesks.validation.serving[0]?.queue_number ?? null;
                    const validationChanged = newValidationNumber && newValidationNumber !== this.lastValidationNumber;

                    if (validationChanged) {
                        this.lastValidationNumber = newValidationNumber;
                        this.flashDesk = 'validation';
                        setTimeout(() => { this.flashDesk = null; }, 4000);

                        if (this.soundEnabled) this.playChimeTone();

                        if (this.voiceEnabled) {
                            setTimeout(() => {
                                const ticketPart = newValidationNumber.split('-')[1] || newValidationNumber;
                                const readableNo = ticketPart.replace(/^0+/, '') || '0';
                                const phrase = `Queue number, ${ticketPart}, please proceed to, Document Validation, Counter 1. Numero, ${readableNo}, pumunta sa Document Validation.`;
                                this.announceText(phrase);
                            }, 800);
                        }
                    } else if (hasNewEntry && this.soundEnabled) {
                        this.playChimeTone();
                    }
                },

                updateClock() {
                    const now = new Date();
                    this.timeString = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', second: '2-digit', hour12: true });
                    this.dateString = now.toLocaleDateString('en-US', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
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
                        case 'Senior':
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
                        case 'validation': return 'bg-[#0038a8]';
                        case 'assessment': return 'bg-indigo-600';
                        case 'review': return 'bg-[#ce1126]';
                        case 'releasing': return 'bg-emerald-600';
                        default: return 'bg-slate-500';
                    }
                },

                getDeskBorderClass(deskKey) {
                    switch (deskKey) {
                        case 'validation': return 'border-t-[6px] border-t-[#0038a8]';
                        case 'assessment': return 'border-t-[6px] border-t-indigo-600';
                        case 'review': return 'border-t-[6px] border-t-[#ce1126]';
                        case 'releasing': return 'border-t-[6px] border-t-emerald-600';
                        default: return '';
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
                        let defaultVoice = voices.find(v => v.lang.includes('PH') || v.lang.includes('en-PH'));
                        if (!defaultVoice) defaultVoice = voices.find(v => v.lang.includes('en-US')) || voices[0];
                        if (defaultVoice) utterance.voice = defaultVoice;

                        window.speechSynthesis.speak(utterance);
                    }
                }
            };
        }
    </script>
</body>
</html>