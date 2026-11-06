@props(['profile'])

<div class="w-full max-w-xl mx-auto bg-gradient-to-br from-slate-900 to-indigo-950 text-white rounded-2xl shadow-xl p-8 flex flex-col items-center justify-center text-center transition-all duration-300 hover:shadow-2xl">
    
    <!-- Circular Frame Avatar / Initials Parsing -->
    <div class="mb-4">
        @if(!empty($profile['avatar']) && Storage::disk('public')->exists($profile['avatar']))
            <img src="{{ asset('storage/' . $profile['avatar']) }}" alt="{{ $profile['name'] }}" class="w-20 h-20 rounded-full border-4 border-slate-700 object-cover shadow-inner">
        @else
            <div class="w-20 h-20 rounded-full border-4 border-slate-700 bg-slate-800 text-slate-200 flex items-center justify-center text-2xl font-bold tracking-wider uppercase select-none">
                {{ strtoupper(substr($profile['name'] ?? 'U', 0, 2)) }}
            </div>
        @endif
    </div>

    
    <div class="mb-4">
        <h3 class="text-2xl font-extrabold tracking-tight text-slate-100">{{ $profile['name'] ?? 'Zulqarnaen' }}</h3>
        <p class="text-sm font-semibold tracking-wide text-indigo-400 mt-0.5 uppercase">{{ $profile['title'] ?? 'First Time Learner' }}</p>
    </div>

    <!-- Personal Developer Toolkit Bio -->
    <p class="text-sm text-slate-300 max-w-sm leading-relaxed mb-6 font-medium">
        {{ $profile['bio'] ?? 'Write a short, engaging description about your core skillsets, developer toolkit, or personal projects here.' }}
    </p>

    <!-- Client-Side Target Inline High-Precision QR Canvas Wrapper Element -->
    <div class="flex items-center justify-center bg-white p-1.5 rounded-full shadow-md">
        <div class="native-qr-canvas-instance" data-target-url="{{ $profile['url'] ?? '#' }}"></div>
    </div>

</div>