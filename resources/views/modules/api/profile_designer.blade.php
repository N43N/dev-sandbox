@extends('layouts.sandbox')

@section('title', 'Profile Card Designer')

@section('content')
    <div class="space-y-6 max-w-7xl mx-auto p-2">
        
        <!-- Module Header unit -->
        <div class="border-b border-gray-200 pb-4">
            <h1 class="text-2xl font-bold text-gray-900">🎨 Profile Card Designer & QR Engine</h1>
            <p class="text-sm text-gray-500 mt-0.5">Practicing complex form data variable handshakes and dynamic telemetry asset matrix generations.</p>
        </div>

        <!-- Main Workspace Split Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-5 gap-8 items-start">
            
            <!-- LEFT COLUMN: Input Configuration Form (Takes up 2 parts of 5) -->
            <div class="lg:col-span-2 bg-white border border-gray-200 p-6 rounded-2xl shadow-sm space-y-6">
                <div>
                    <h2 class="text-sm font-bold uppercase tracking-wider text-indigo-600">⚡ Identity Parameters</h2>
                    <p class="text-xs text-gray-400 mt-1">Modify your profile fields below to re-compile your identity presentation canvas.</p>
                </div>

                <form action="{{ route('profile.designer.generate') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf
                    
                    <!-- Profile Name Input -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Profile Name</label>
                        <input type="text" name="name" required max="50" value="{{ old('name', $profile['name'] != 'Your Full Name' ? $profile['name'] : '') }}" placeholder="e.g. Zul Naen" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Professional Title Input -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Professional Designation</label>
                        <input type="text" name="title" required max="60" value="{{ old('title', $profile['title'] != 'Professional Designation' ? $profile['title'] : '') }}" placeholder="e.g. Laravel Full-Stack Developer" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>

                    <!-- Biography Textarea Input -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">Biography Description</label>
                        <textarea name="bio" required rows="3" max="160" placeholder="Write a short summary (max 160 characters)..." class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-900 font-medium text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 leading-relaxed">{{ old('bio', $profile['bio'] != 'Write a short, engaging description about your core skillsets, developer toolkit, or personal projects here.' ? $profile['bio'] : '') }}</textarea>
                    </div>

                    <!-- Target URL / Redirect Action input -->
                    <div>
                        <label class="block text-xs font-semibold text-gray-500 uppercase mb-1.5">QR Destination URL Link</label>
                        <input type="url" name="url" required value="{{ old('url', $profile['url'] != 'https://github.com' ? $profile['url'] : '') }}" placeholder="https://yourportfolio.test" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-900 font-medium text-xs focus:outline-none focus:ring-2 focus:ring-indigo-500 font-mono">
                    </div>

                    <!-- Submission Engine Button -->
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-xs transition-all flex items-center justify-center gap-2 group text-sm mt-2">
                        <span>Generate Canvas Card</span>
                        <span class="transform group-hover:rotate-12 transition-transform">🎨</span>
                    </button>

                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase tracking-wider mb-2">Profile Picture Image</label>
                        <input type="file" name="avatar" accept="image/*" class="w-full text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-semibold file:bg-indigo-600 file:text-white hover:file:bg-indigo-700 cursor-pointer">
                    </div>
                
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-md transition shadow-md">
                        Save & Update Profile Canvas
                    </button>
                </form>
            </div>

            <!-- RIGHT COLUMN: The Visual Live Canvas Card Preview (Takes up 3 parts of 5) -->
            <div class="lg:col-span-3 space-y-6">
                
                <!-- Success Toast Banner -->
                @if(session('status_success'))
                    <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3 rounded-xl text-xs font-medium font-mono flex items-center gap-2">
                        <span>✨</span> {{ session('status_success') }}
                    </div>
                @endif

                <div class="flex items-center justify-center p-6 bg-slate-900/50 rounded-2xl border border-slate-800">
                    <x-profile_card_canvas :profile="$profile" />
                </div>

                <!-- Dashboard Modules Telemetry Navigation Link Helper -->
                <div class="bg-slate-50 border border-gray-200 rounded-xl p-4 text-[11px] text-gray-500 space-y-1">
                    <span class="font-bold text-gray-700 uppercase block tracking-wider">🔬 Architectural Sandbox Parameters:</span>
                    <p>• Data Binding Engine uses native blade mapping variables (`$profile['parameter_key']`).</p>
                    <p>• QR Generation matrix runs standalone native layout logic independent of external tracking vectors.</p>
                </div>
                
            </div>

        </div>
    </div>

    <!-- 🚀 High-performance, lightweight native client-side QR generation engine -->
    <script src="https://cloudflare.com" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        (function() {
            function renderQR() {
                const qrContainer = document.getElementById("native-qr-canvas");
                if (!qrContainer) return;
                
                // Wipe out stale layout vector nodes or text before repaint
                qrContainer.innerHTML = "";

                const targetUrl = qrContainer.getAttribute("data-target-url");
                if (targetUrl && targetUrl.trim() !== "") {
                    // Initialize the official QRCode engine
                    new QRCode(qrContainer, {
                        text: targetUrl,
                        width: 146,
                        height: 146,
                        colorDark : "#0f172a", // Perfect match for modern Tailwind Slate-900
                        colorLight : "#ffffff",
                        correctLevel : QRCode.CorrectLevel.H
                    });
                }
            }

            // Resilient Lifecycle Hook Execution
            if (document.readyState === "loading") {
                document.addEventListener("DOMContentLoaded", renderQR);
            } else {
                renderQR(); // Run instantly if DOM is already parsed
            }
            window.addEventListener('load', renderQR);
        })();
    </script>
@endsection

