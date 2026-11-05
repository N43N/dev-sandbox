@extends('layouts.sandbox')

@section('title', 'Launchpad Central')

@section('content')
    <!-- Launchpad Hero Header Zone -->
    <div class="border-b border-gray-200 pb-4 mb-6">
        <h1 class="text-2xl font-bold text-gray-900">🎛️ Developer Hub Sandbox Launchpad</h1>
        <p class="text-sm text-gray-500 mt-1">Welcome to your modular programming laboratory. This central station coordinates your active tool micro-apps and experiments.</p>
    </div>

    <!-- Active Sandbox Applications Micro Grid Loop -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
        
        <!-- Welcome Master Module Card (Fixed Base Element) -->
        <div class="p-5 border-2 border-dashed border-gray-200 rounded-xl bg-gray-50 flex flex-col justify-between h-48">
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
        <div class="p-5 border border-gray-200 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between h-48">
            <div>
                <span class="text-2xl block mb-2">📝</span>
                <h3 class="font-bold text-gray-800 text-base">Markdown Notepad</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Isolated CRUD experiment space testing user-bound relational database tables and token character wrapping bounds.</p>
            </div>
            <a href="{{ route('notes.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider mt-3 flex items-center gap-0.5">
                Open Module &rarr;
            </a>
        </div>

        <!-- Kanban Matrix Module Shortcut Card -->
        <div class="p-5 border border-gray-200 bg-white rounded-xl shadow-sm hover:shadow-md transition-shadow flex flex-col justify-between h-48">
            <div>
                <span class="text-2xl block mb-2">📋</span>
                <h3 class="font-bold text-gray-800 text-base">Kanban Board Matrix</h3>
                <p class="text-xs text-gray-500 mt-1 leading-relaxed">Multi-state ticket pipeline engine showcasing modular form toggle arrays and data table patch adjustments.</p>
            </div>
            <a href="{{ route('kanban.index') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-800 uppercase tracking-wider mt-3 flex items-center gap-0.5">
                Open Kanban Matrix &rarr;
            </a>
        </div>

    <!-- Active Laboratory Modules Board Grid -->
    <div class="mt-8">
        <h2 class="text-xs font-bold uppercase tracking-wider text-gray-400 mb-4 flex items-center gap-2">
            <span>🎛️</span> Active Integration Modules Board
        </h2>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 w-full">
            
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

        </div>
    </div>

</div>
@endsection
