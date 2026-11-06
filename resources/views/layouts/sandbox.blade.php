<!DOCTYPE html>
<html lang="en" class="h-full bg-gray-100">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sandbox Central') - DevHub</title>
    <!-- Tailwind CSS is bundled automatically by Laravel Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full flex flex-col font-sans antialiased text-gray-900">

    <!-- Top Dynamic Sticky Header Navbar -->
    <header class="bg-white border-b border-gray-200 sticky top-0 z-40">
        <div class="max-w-[100%] mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-3">
                <span class="text-xl">🛠️</span>
                <span class="font-bold text-lg tracking-tight text-gray-900">DevHub Sandbox</span>
            </div>
            
            <div class="flex items-center space-x-4">
                @auth
                    <span class="text-sm text-gray-600 font-medium">👋 {{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}" class="inline m-0 p-0">
                        @csrf
                        <button type="submit" class="text-sm font-semibold text-red-600 hover:text-red-700 transition-colors">Log Out</button>
                    </form>
                @endauth
            </div>
        </div>
    </header>

    <!-- Main Workspace Container Split -->
    <div class="flex flex-1 max-w-[100%] w-full mx-auto px-6 py-6 gap-6 items-start">
        
        <!-- Left Modular Sidebar Navigation Panel Drawer -->
        <aside class="w-64 bg-white border border-gray-200 rounded-xl p-4 shrink-0 shadow-sm space-y-6">
            <div>
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">Core Platform</p>
                <nav class="space-y-1">
                    <a href="{{ route('dashboard') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>🎛️ Launchpad Dashboard</span>
                    </a>

                    <a href="{{ route('profile.edit') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('profile.edit') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>⚙️ Account Settings</span>
                    </a>
                </nav>
            </div>

            <!-- 🧪 THE EXPERIMENT MODULES ZONE -->
            <div>
                <p class="px-3 text-xs font-semibold text-gray-400 uppercase tracking-wider mb-2">My Active Experiments</p>
                <nav class="space-y-1" id="sandbox-modules-menu">
                    <!-- Live Markdown Notepad Route Shortcut Link -->
                    <a href="{{ route('notes.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('notes.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>📝 Markdown Notepad</span>
                    </a>

                    <a href="{{ route('kanban.index') }}" class="flex items-center px-3 py-2 text-sm font-medium rounded-lg {{ request()->routeIs('kanban.index') ? 'bg-indigo-50 text-indigo-700' : 'text-gray-600 hover:bg-gray-50' }}">
                        <span>📋 Kanban Board Matrix</span>
                    </a>

                    <!-- 📡 API Client Laboratory Link -->
                    <a href="{{ route('api.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm transition-all border border-transparent
                    {{ request()->routeIs('api.index') ? 'bg-indigo-50 text-indigo-700 border-indigo-100 shadow-xs' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span>⚠️ 📡 API Client Laboratory</span>
                    </a>

                    <!-- 💵 Currency Exchange Matrix Link -->
                    <a href="{{ route('api.currency') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm transition-all border border-transparent
                    {{ request()->routeIs('api.currency') ? 'bg-indigo-50 text-indigo-700 border-indigo-100 shadow-xs' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span>💵 Currency Exchange</span>
                    </a>

                    <!-- ✉️ Email Verification Lab Link -->
                    <a href="{{ route('email.verify.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm transition-all border border-transparent
                    {{ request()->routeIs('email.verify.index') ? 'bg-indigo-50 text-indigo-700 border-indigo-100 shadow-xs' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span>⚠️ ✉️ Email Verification</span>
                    </a>

                    <!-- 🎨 Brand New: Profile Card Designer Link -->
                    <a href="{{ route('profile.designer.index') }}"
                    class="flex items-center space-x-3 px-4 py-2.5 rounded-xl font-medium text-sm transition-all border border-transparent
                    {{ request()->routeIs('profile.designer.index') ? 'bg-indigo-50 text-indigo-700 border-indigo-100 shadow-xs' : 'text-gray-700 hover:bg-gray-100' }}">
                        <span>🎨</span>
                        <span>Profile Designer</span>
                    </a>



                </nav>
            </div>
        </aside>

        <!-- Main Body Action Playground Canvas -->
        <main class="flex-1 bg-white border border-gray-200 rounded-xl p-6 shadow-sm min-h-[500px]">
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 text-sm rounded-r-md">
                    {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <!-- Sticky Base Footer Panel -->
    <footer class="bg-white border-t border-gray-200 py-4 mt-auto">
        <div class="max-w-[100%] mx-auto px-6 text-center text-xs text-gray-400 font-medium">
            DevHub Lab System Platform &bull; Running in Local Sandbox Workspace
        </div>
    </footer>
</body>
</html>
