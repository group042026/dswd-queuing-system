<x-admin-layout>
    <style>
        :root {
            --dswd-blue: #0038a8;
            --dswd-blue-hover: #002878;
            --dswd-blue-light: rgba(0, 56, 168, 0.06);
            --dswd-blue-border: rgba(0, 56, 168, 0.12);
            --dswd-red: #ce1126;
            --dswd-red-hover: #b00e1f;
            --bg-gray: #f8fafc;
            --card-bg: #ffffff;
            --border-color: #cbd5e1;
            --text-primary: #0f172a;
            --text-muted: #64748b;
            --text-white: #ffffff;
        }

        .backup-container {
            padding: 24px;
            max-width: 1300px;
            margin: 0 auto;
        }

        .backup-header {
            background: linear-gradient(135deg, var(--dswd-blue) 0%, #1e40af 50%, var(--dswd-red) 100%);
            border-radius: 16px;
            padding: 28px 24px;
            color: var(--text-white);
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }
    </style>

    <div class="backup-container">

        <!-- Flash Messages -->
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-emerald-100 text-emerald-600 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">{{ session('success') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 flex items-center justify-between shadow-sm animate-fade-in">
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-rose-100 text-rose-600 flex items-center justify-center flex-shrink-0">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                    </div>
                    <p class="text-sm font-semibold">{{ session('error') }}</p>
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-700">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-amber-50 border border-amber-200 text-amber-800 shadow-sm">
                <div class="flex items-center gap-2 font-semibold text-sm mb-1">
                    <svg class="h-4 w-4 text-amber-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                    <span>Validation Notice</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Banner Header -->
        <div class="backup-header">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-1.5">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-white/20 text-white backdrop-blur-sm">
                            System Management
                        </span>
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-400/20 text-white border border-emerald-300/30">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            {{ $dbDriver }} Active
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">Database Backup & Restore</h1>
                    <p class="text-sm text-blue-100 mt-1">Export complete database snapshots or restore previous backups with cross-database support (SQLite & MySQL).</p>
                </div>

                <div class="flex items-center gap-3">
                    <form method="POST" action="{{ route('admin.backup.create') }}">
                        @csrf
                        <button type="submit" 
                                class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-white hover:bg-blue-50 text-blue-700 font-bold text-sm shadow-md transition-all duration-200 hover:shadow-lg active:scale-95">
                            <svg class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Create Backup Now</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Metric Stat Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <!-- Database Engine -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Active Engine</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ $dbDriver }}</p>
                    <p class="text-xs text-slate-400 mt-0.5 truncate max-w-[170px]" title="{{ $dbName }}">{{ $dbName }}</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                    </svg>
                </div>
            </div>

            <!-- Current DB Size -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Database Size</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ $dbSize }}</p>
                    <p class="text-xs text-emerald-600 mt-0.5 font-medium flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Live Data Storage
                    </p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 9.776c.112-.017.227-.026.344-.026h15.812c.117 0 .232.009.344.026m-16.5 0a2.25 2.25 0 0 0-1.883 2.542l.857 6a2.25 2.25 0 0 0 2.227 1.932H19.05a2.25 2.25 0 0 0 2.227-1.932l.857-6a2.25 2.25 0 0 0-1.883-2.542m-16.5 0V6A2.25 2.25 0 0 1 6 3.75h3.879a1.5 1.5 0 0 1 1.06.44l2.122 2.12a1.5 1.5 0 0 0 1.06.44H18A2.25 2.25 0 0 1 20.25 9v.776" />
                    </svg>
                </div>
            </div>

            <!-- Available Backups -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Saved Backups</p>
                    <p class="text-xl font-bold text-slate-800 mt-1">{{ count($backups) }}</p>
                    <p class="text-xs text-slate-400 mt-0.5">Stored in local server archive</p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                    </svg>
                </div>
            </div>

            <!-- Last Backup Timestamp -->
            <div class="bg-white rounded-2xl p-5 border border-slate-200/80 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Last Backup</p>
                    <p class="text-base font-bold text-slate-800 mt-1">
                        {{ $lastBackup ? $lastBackup->diffForHumans() : 'None Yet' }}
                    </p>
                    <p class="text-xs text-slate-400 mt-0.5">
                        {{ $lastBackup ? $lastBackup->format('M d, Y h:i A') : 'Create your first snapshot' }}
                    </p>
                </div>
                <div class="h-12 w-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
            </div>
        </div>

        <!-- Action Cards Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Quick Create Card -->
            <div class="bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Generate Backup</h2>
                            <p class="text-xs text-slate-500">Fast one-click database snapshot</p>
                        </div>
                    </div>

                    <p class="text-xs text-slate-600 leading-relaxed mb-4">
                        Creates an immediate snapshot of all active tables, queues, clients, users, activity logs, and assessments. Compatible with <strong>{{ $dbDriver }}</strong>.
                    </p>

                    <div class="p-3 bg-slate-50 rounded-xl text-xs space-y-1.5 text-slate-600 border border-slate-100 mb-4">
                        <div class="flex justify-between">
                            <span class="text-slate-400">Target Format:</span>
                            <span class="font-semibold text-slate-700">{{ $dbDriver === 'SQLite' ? '.sqlite binary snapshot' : '.sql script dump' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-slate-400">Storage Location:</span>
                            <span class="font-semibold text-slate-700">storage/app/backups/</span>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.backup.create') }}">
                    @csrf
                    <button type="submit" 
                            class="w-full inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm transition shadow-sm active:scale-95">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        <span>Create Database Backup</span>
                    </button>
                </form>
            </div>

            <!-- Upload & Restore Card -->
            <div class="lg:col-span-2 bg-white rounded-2xl p-6 border border-slate-200/80 shadow-sm flex flex-col justify-between">
                <div>
                    <div class="flex items-center gap-3 mb-3">
                        <div class="h-10 w-10 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5m-13.5-9L12 3m0 0 4.5 4.5M12 3v13.5" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-base font-bold text-slate-800">Upload & Restore External Backup</h2>
                            <p class="text-xs text-slate-500">Restore database from your local machine</p>
                        </div>
                    </div>

                    <div class="p-3 bg-amber-50/70 border border-amber-200/70 rounded-xl text-xs text-amber-900 mb-4 flex items-start gap-2.5">
                        <svg class="h-4 w-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                        </svg>
                        <div>
                            <strong class="font-semibold">Notice:</strong> Restoring will overwrite the current live database. Ensure users are not actively undergoing client releasing before proceeding.
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('admin.backup.restore') }}" enctype="multipart/form-data" 
                      x-data="{ fileName: '' }" 
                      onsubmit="return confirm('⚠️ WARNING: Restoring this file will overwrite existing database records. Are you sure you want to proceed?');">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-center gap-3">
                        <div class="relative flex-1 w-full">
                            <input type="file" 
                                   name="backup_file" 
                                   id="backup_file" 
                                   accept=".sql,.sqlite"
                                   required
                                   @change="fileName = $event.target.files[0] ? $event.target.files[0].name : ''"
                                   class="block w-full text-xs text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-slate-100 file:text-slate-700 hover:file:bg-slate-200 cursor-pointer border border-slate-200 rounded-xl bg-slate-50/50 focus:outline-none focus:ring-2 focus:ring-blue-500/20" />
                        </div>
                        <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-5 py-2.5 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-semibold text-sm transition shadow-sm active:scale-95 whitespace-nowrap">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg>
                            <span>Upload & Restore</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Backups List Table -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="text-base font-bold text-slate-800">Available Server Backups</h2>
                    <p class="text-xs text-slate-500 mt-0.5">Stored database backup snapshots available for download or immediate restoration</p>
                </div>
                <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-slate-100 text-slate-700">
                    {{ count($backups) }} Backups Stored
                </span>
            </div>

            @if (empty($backups))
                <div class="p-12 text-center">
                    <div class="h-16 w-16 rounded-2xl bg-blue-50 text-blue-400 mx-auto flex items-center justify-center mb-3">
                        <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125m16.5 5.625c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-bold text-slate-700">No Backups Found</h3>
                    <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">Click "Create Backup Now" above to generate your first snapshot archive.</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse text-xs">
                        <thead>
                            <tr class="bg-slate-50/75 border-b border-slate-100 text-slate-500 font-semibold uppercase tracking-wider">
                                <th class="py-3 px-4">Backup File</th>
                                <th class="py-3 px-4">Engine</th>
                                <th class="py-3 px-4">Size</th>
                                <th class="py-3 px-4">Created Date</th>
                                <th class="py-3 px-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-slate-700">
                            @foreach ($backups as $index => $backup)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="py-3.5 px-4">
                                        <div class="flex items-center gap-3">
                                            <div class="h-8 w-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center flex-shrink-0">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                                </svg>
                                            </div>
                                            <div>
                                                <p class="font-bold text-slate-800 text-xs">{{ $backup['filename'] }}</p>
                                                <p class="text-[10px] text-slate-400 uppercase tracking-wider">.{{ $backup['extension'] }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3.5 px-4">
                                        @if ($backup['driver'] === 'SQLite')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-purple-100 text-purple-700">
                                                SQLite
                                            </span>
                                        @elseif ($backup['driver'] === 'MySQL')
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-blue-100 text-blue-700">
                                                MySQL
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 text-slate-600">
                                                {{ $backup['driver'] }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="py-3.5 px-4 font-semibold text-slate-600">
                                        {{ $backup['size'] }}
                                    </td>
                                    <td class="py-3.5 px-4">
                                        <p class="font-medium text-slate-700">{{ $backup['created_at']->format('M d, Y h:i A') }}</p>
                                        <p class="text-[10px] text-slate-400">{{ $backup['created_at']->diffForHumans() }}</p>
                                    </td>
                                    <td class="py-3.5 px-4 text-right">
                                        <div class="inline-flex items-center gap-1.5 justify-end">
                                            <!-- Download Button -->
                                            <a href="{{ route('admin.backup.download', $backup['filename']) }}" 
                                               title="Download backup file"
                                               class="inline-flex items-center gap-1 px-2.5 py-1.5 rounded-lg bg-blue-50 text-blue-700 hover:bg-blue-100 font-semibold text-xs transition">
                                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                                </svg>
                                                <span>Download</span>
                                            </a>

                                            <!-- Restore Button -->
                                            <x-primary-button 
                                                type="button"
                                                x-on:click="$dispatch('open-modal', 'restore-modal-{{ $index }}')"
                                                class="!bg-amber-500 hover:!bg-amber-600 !text-white !px-2.5 !py-1.5 !rounded-lg !text-xs !font-semibold">
                                                <svg class="h-3.5 w-3.5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>
                                                Restore
                                            </x-primary-button>

                                            <!-- Delete Button -->
                                            <button 
                                                type="button"
                                                x-on:click="$dispatch('open-modal', 'delete-modal-{{ $index }}')"
                                                title="Delete backup file"
                                                class="inline-flex items-center px-2 py-1.5 rounded-lg text-rose-600 hover:bg-rose-50 transition">
                                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                </svg>
                                            </button>
                                        </div>

                                        <!-- Modal: Restore Confirmation -->
                                        <x-modal name="restore-modal-{{ $index }}" maxWidth="md">
                                            <div class="p-6 text-left">
                                                <div class="h-12 w-12 rounded-2xl bg-amber-100 text-amber-600 flex items-center justify-center mb-4">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                                    </svg>
                                                </div>

                                                <h3 class="text-base font-bold text-slate-800">Confirm Database Restoration</h3>
                                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                    Are you sure you want to restore the database from this backup?
                                                </p>

                                                <div class="my-4 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs space-y-1">
                                                    <p class="font-bold text-slate-800 break-all">{{ $backup['filename'] }}</p>
                                                    <p class="text-slate-500">Engine: <span class="font-semibold text-slate-700">{{ $backup['driver'] }}</span> | Size: <span class="font-semibold text-slate-700">{{ $backup['size'] }}</span></p>
                                                </div>

                                                <p class="text-xs text-rose-600 font-semibold mb-6">
                                                    ⚠️ All current records since this backup was taken will be replaced.
                                                </p>

                                                <div class="flex items-center justify-end gap-3">
                                                    <x-secondary-button x-on:click="$dispatch('close-modal', 'restore-modal-{{ $index }}')">
                                                        Cancel
                                                    </x-secondary-button>

                                                    <form method="POST" action="{{ route('admin.backup.restore') }}">
                                                        @csrf
                                                        <input type="hidden" name="filename" value="{{ $backup['filename'] }}">
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-amber-600 hover:bg-amber-700 text-white font-semibold text-xs shadow-sm transition">
                                                            Yes, Restore Database
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </x-modal>

                                        <!-- Modal: Delete Confirmation -->
                                        <x-modal name="delete-modal-{{ $index }}" maxWidth="md">
                                            <div class="p-6 text-left">
                                                <div class="h-12 w-12 rounded-2xl bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
                                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                    </svg>
                                                </div>

                                                <h3 class="text-base font-bold text-slate-800">Delete Backup File</h3>
                                                <p class="text-xs text-slate-500 mt-1 leading-relaxed">
                                                    Are you sure you want to delete this backup file from the server? This action cannot be undone.
                                                </p>

                                                <p class="my-3 p-3 bg-slate-50 border border-slate-200 rounded-xl text-xs font-bold text-slate-800 break-all">
                                                    {{ $backup['filename'] }}
                                                </p>

                                                <div class="flex items-center justify-end gap-3 mt-6">
                                                    <x-secondary-button x-on:click="$dispatch('close-modal', 'delete-modal-{{ $index }}')">
                                                        Cancel
                                                    </x-secondary-button>

                                                    <form method="POST" action="{{ route('admin.backup.destroy', $backup['filename']) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" 
                                                                class="inline-flex items-center px-4 py-2 rounded-xl bg-rose-600 hover:bg-rose-700 text-white font-semibold text-xs shadow-sm transition">
                                                            Yes, Delete Backup
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </x-modal>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
