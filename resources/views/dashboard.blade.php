@extends('layouts.sandbox')

@section('title', 'Launchpad Central')

@section('content')
    <!-- TOP HERO & IDENTITY GRID (2 Columns Left + 1 Column Profile Card Right) -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start mb-8">
        
        <!-- Left 2 Columns: Header + Core Micro-Apps -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Launchpad Hero Header Zone -->
            <div class="border-b border-gray-200 pb-4">
                <h1 class="text-2xl font-bold text-gray-900">🎛️ Developer Hub Sandbox Launchpad</h1>
                <p class="text-sm text-gray-500 mt-1">Welcome to your modular programming laboratory. This central station coordinates your active tool micro-apps and experiments.</p>
            </div>

            <!-- Active Sandbox Applications Micro Grid Loop -->
            <div class="grid sm:grid-cols-2 gap-4">
                
                <!-- Welcome Master Module Card -->
                <div class="p-5 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 flex flex-col justify-between h-44">
                    <div>
                        <span class="text-2xl block mb-2">🚀</span>
                        <h3 class="font-bold text-gray-800 text-base">Your Canvas is Ready!</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Ready to practice a new concept? Create an isolated migration, controller folder, view directory, and plug a new card grid route link right here.</p>
                    </div>
                    <div class="text-xs font-semibold text-indigo-600 uppercase tracking-wider mt-3">
                        System Core Active &bull; v1.0
                    </div>
                </div>

                <!-- Active Module Shortcut Link Card -->
                <div class="p-5 border border-gray-200 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between h-44">
                    <div>
                        <span class="text-2xl block mb-2">📝</span>
                        <h3 class="font-bold text-gray-800 text-base">Markdown Notepad</h3>
                        <p class="text-xs text-gray-500 mt-1 leading-relaxed">Isolated CRUD experiment space testing user-bound relational database tables and token character wrapping bounds.</p>
                    </div>
                    <a href="{{ route('notes.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider mt-3 flex items-center gap-0.5">
                        Open Module &rarr;
                    </a>
                </div>

                <!-- Kanban Matrix Module Shortcut Card (Spans 2 columns cleanly underneath) -->
                <div class="sm:col-span-2 p-5 border border-gray-200 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow flex items-center justify-between gap-4">
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xl">📋</span>
                            <h3 class="font-bold text-gray-800 text-base">Kanban Board Matrix</h3>
                        </div>
                        <p class="text-xs text-gray-500 leading-relaxed">Multi-state ticket pipeline engine showcasing modular form toggle arrays and data table patch adjustments.</p>
                    </div>
                    <a href="{{ route('kanban.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider shrink-0 bg-indigo-50 px-3 py-2 rounded-lg border border-indigo-100">
                        Open Matrix &rarr;
                    </a>
                </div>

            </div>
        </div>

        
        <div class="lg:col-span-1 space-y-3">
            <div class="flex items-center justify-between">
                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400">Active Profile Identity</h4>
                <a href="{{ route('profile.designer.index') }}" class="text-[10px] font-bold text-indigo-600 hover:text-indigo-800 transition-colors uppercase tracking-wider bg-indigo-50 px-2 py-0.5 rounded-md border border-indigo-100">
                    Edit Card ⚙️
                </a>
            </div>
            
            <x-profile_card_canvas :profile="$profile" />
        </div>

    </div>

    <!-- Active Laboratory Modules Board Grid -->
    <div class="mt-8">
        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4 flex items-center gap-2">
            <span>🎛️</span> Active Integration Modules Board
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
            
            <!-- Module Card 1: API Stream Lab -->
            <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xs hover:shadow-md transition-all flex flex-col justify-between group min-h-[220px]">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-indigo-50 border border-indigo-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">📡</div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">API Stream Laboratory</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Handles third-party network connections fetching asynchronous programming advice payloads and regional weather metrics grids.</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50">
                    <a href="{{ route('api.index') }}" class="w-full bg-gray-50 hover:bg-indigo-600 hover:text-white text-gray-600 font-bold text-[11px] py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <span>Enter Laboratory</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Module Card 2: Currency Exchange Matrix -->
            <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xs hover:shadow-md transition-all flex flex-col justify-between group min-h-[220px]">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-amber-50 border border-amber-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">💵</div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Currency Converter Matrix</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Processes dynamic floating-point conversion ratios from global financial networks, backed by multi-layered associative arrays.</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50">
                    <a href="{{ route('api.currency') }}" class="w-full bg-gray-50 hover:bg-amber-600 hover:text-white text-gray-600 font-bold text-[11px] py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <span>Enter Laboratory</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Module Card 3: Email Verification Sandbox -->
            <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xs hover:shadow-md transition-all flex flex-col justify-between group min-h-[220px]">
                <div class="space-y-3">
                    <div class="w-10 h-10 bg-emerald-50 border border-emerald-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform">✉️</div>
                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Email Verification Playground</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Simulates secure authentication layers using cryptographic, temporary signed token links communicating with local SMTP engines.</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50">
                    <a href="{{ route('email.verify.index') }}" class="w-full bg-gray-50 hover:bg-emerald-600 hover:text-white text-gray-600 font-bold text-[11px] py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <span>Enter Laboratory</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Module Card 4: Expense Analytics Chart -->
            <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xs hover:shadow-md transition-all flex flex-col justify-between group min-h-[220px]">
                <div class="space-y-3">
                    <!-- Top Row: Icon on Left + Total Logged Spending Badge on Right -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-10 h-10 bg-rose-50 border border-rose-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform shrink-0">💰</div>
                        
                        <div class="bg-rose-50/80 border border-rose-100 px-3 py-1.5 rounded-xl text-right">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-rose-400 block leading-none">Total Logged</span>
                            <span class="text-xs font-black text-rose-700">RM {{ number_format($totalExpense ?? 0, 2) }}</span>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Expense Analytics Matrix</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Tracks personal spending using SQL group aggregations piped into dynamic Chart.js doughnut visualizations.</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50">
                    <a href="{{ route('expenses.index') }}" class="w-full bg-gray-50 hover:bg-rose-600 hover:text-white text-gray-600 font-bold text-[11px] py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <span>Enter Laboratory</span>
                        <span>➔</span>
                    </a>
                </div>
            </div>

            <!-- Module Card 5: Geospatial & Coordinate Pin Sandbox -->
            <div class="bg-white border border-gray-100 p-6 rounded-2xl shadow-xs hover:shadow-md transition-all flex flex-col justify-between group min-h-[220px]">
                <div class="space-y-3">
                    <!-- Top Row: Icon on Left + Live Pin Count Badge on Right -->
                    <div class="flex items-center justify-between gap-2">
                        <div class="w-10 h-10 bg-teal-50 border border-teal-100 rounded-xl flex items-center justify-center text-lg group-hover:scale-110 transition-transform shrink-0">📍</div>

                        <div class="bg-teal-50/80 border border-teal-100 px-3 py-1.5 rounded-xl text-right">
                            <span class="text-[9px] font-bold uppercase tracking-wider text-teal-500 block leading-none">Saved Pins</span>
                            <span class="text-xs font-black text-teal-700">{{ auth()->user()->locations()->count() }} {{ Str::plural('Pin', auth()->user()->locations()->count()) }}</span>
                        </div>
                    </div>

                    <div>
                        <h3 class="font-bold text-gray-800 text-sm">Geospatial Pin Sandbox</h3>
                        <p class="text-xs text-gray-400 mt-1 leading-relaxed">Interactive Leaflet.js and OpenStreetMap workspace to capture and inspect WGS84 coordinate pins.</p>
                    </div>
                </div>
                <div class="mt-4 pt-3 border-t border-gray-50">
                    <a href="{{ route('gis.index') }}" class="w-full bg-gray-50 hover:bg-teal-600 hover:text-white text-gray-600 font-bold text-[11px] py-2 px-3 rounded-xl transition-all flex items-center justify-center gap-1.5">
                        <span>Enter Laboratory</span>
                        <span>&rarr;</span>
                    </a>
                </div>
            </div>

        </div> <!-- Closes active laboratory modules board row grid -->
    </div> <!-- Closes active laboratory modules board wrapper container -->

    <!-- Live Active Micro Preview Panel Zone Layout -->
    <div class="mt-8">

        <!-- Left/Center Multi-Span Column Container -->
        <div class="lg:col-span-2 bg-white border border-gray-100 p-6 rounded-2xl shadow-sm">
            <h3 class="font-bold text-slate-800 text-base">Workspace Statistics Summary</h3>
            <p class="text-xs text-slate-400 mt-1 leading-relaxed">Your isolated testing arrays are executing with 100% processing runtime efficiency metrics.</p>
            <div class="mt-4 h-32 bg-slate-50 border border-dashed border-slate-200 rounded-xl flex items-center justify-center text-xs text-slate-400">
                Data charts pipeline placeholder
            </div>
        </div>

    </div>
@endsection
