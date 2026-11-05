@extends('layouts.sandbox')

@section('title', 'API Integration Lab')

@section('content')
<div class="space-y-6">
    <div class="border-b border-gray-200 pb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-900">📡 Live API Stream Laboratory</h1>
            <p class="text-sm text-gray-500 mt-0.5">Practicing out-of-network HTTP protocols with isolated asynchronous card refreshes.</p>
        </div>
        <a href="{{ route('api.index') }}" class="bg-slate-800 hover:bg-slate-900 text-white font-semibold text-xs px-3 py-1.5 rounded-lg shadow transition-all">
            🔄 Global Page Refresh
        </a>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        
        <!-- CARD 1: Random Programming Advice -->
        <div class="bg-gradient-to-br from-slate-900 to-slate-800 text-white border border-slate-700 p-6 rounded-2xl shadow-sm relative overflow-hidden flex flex-col justify-between min-h-[180px]">
            <div class="absolute right-4 top-2 text-slate-700/40 text-7xl font-bold font-serif pointer-events-none">“</div>
            <div>
                <div class="flex justify-between items-center">
                    <span class="text-xs font-bold uppercase tracking-wider text-indigo-400 bg-indigo-950/60 border border-indigo-900 px-2 py-0.5 rounded">Advice Slip API</span>
                    <!-- 🔄 Isolated Refresh Trigger Button -->
                    <button id="btn-refresh-advice" class="text-slate-400 hover:text-indigo-400 transition-colors p-1 rounded-lg hover:bg-slate-800 text-xs font-semibold flex items-center gap-1">
                        <span>Force Refresh</span> 🔄
                    </button>
                </div>
                <p id="advice-text" class="mt-4 text-base font-medium leading-relaxed italic text-slate-100 transition-all duration-300">
                    "{{ $advice }}"
                </p>
            </div>
            <div class="text-[10px] text-slate-400 border-t border-slate-700/60 pt-3 mt-4">
                Endpoint: <span class="font-mono text-indigo-300">http://adviceslip.com</span>
            </div>
        </div>

        <!-- CARD 2: Weather Stream -->
        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex flex-col justify-between min-h-[180px] relative">
            <div>
                <div class="flex justify-between items-start">
                    <div>
                        <span class="text-xs font-bold uppercase tracking-wider text-amber-700 bg-amber-50 border border-amber-200 px-2 py-0.5 rounded">Meteo Weather API</span>
                        <h3 class="font-bold text-gray-900 text-lg mt-2">📍 {{ $locationName }}</h3>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- 🔄 Isolated Refresh Trigger Button -->
                        <button id="btn-refresh-weather" class="text-gray-400 hover:text-amber-600 transition-colors p-1 rounded-lg hover:bg-gray-100 text-xs font-semibold flex items-center gap-1">
                            <span>Force Refresh</span> 🔄
                        </button>
                        <span id="weather-icon" class="text-3xl">{{ $weatherData ? '🌤️' : '⚠️' }}</span>
                    </div>
                </div>

                <!-- Live Grid Output Container -->
                <div id="weather-grid-container" class="mt-4">
                    @if($weatherData)
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Temperature</span>
                                <span id="val-temp" class="text-base font-bold text-gray-800">{{ $weatherData['temperature_2m'] }}°C</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Feels Like</span>
                                <span id="val-feels" class="text-base font-bold text-gray-800">{{ $weatherData['apparent_temperature'] }}°C</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Humidity</span>
                                <span id="val-humid" class="text-base font-bold text-gray-800">{{ $weatherData['relative_humidity_2m'] }}%</span>
                            </div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100">
                                <span class="block text-[10px] text-gray-400 uppercase font-semibold">Wind Vector</span>
                                <span id="val-wind" class="text-base font-bold text-gray-800">{{ $weatherData['wind_speed_10m'] }} km/h</span>
                            </div>
                        </div>
                    @else
                        <p id="weather-error-msg" class="text-xs text-red-500 font-mono font-medium bg-red-50 p-2 rounded border border-red-100">{{ $weatherError }}</p>
                    @endif
                </div>
            </div>

            <div class="text-[10px] text-gray-400 border-t border-gray-100 pt-3 mt-4">
                Endpoint: <span class="font-mono text-amber-600">http://open-meteo.com</span>
            </div>
        </div>

    </div>
</div>

<!-- 🧠 Asynchronous AJAX Pipeline Engine -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    
    // 📡 Pipeline A: Fetch Live Advice Stream
    document.getElementById('btn-refresh-advice').addEventListener('click', function() {
        const textElement = document.getElementById('advice-text');
        textElement.style.opacity = '0.4'; // Visual cue that data is loading
        
        fetch("{{ route('api.refresh.advice') }}")
            .then(res => res.json())
            .then(data => {
                textElement.innerText = `"${data.advice}"`;
                textElement.style.opacity = '1';
            })
            .catch(() => {
                textElement.style.opacity = '1';
            });
    });

    // 📡 Pipeline B: Fetch Live Weather Telemetry Arrays
    document.getElementById('btn-refresh-weather').addEventListener('click', function() {
        const container = document.getElementById('weather-grid-container');
        const iconElement = document.getElementById('weather-icon');
        container.style.opacity = '0.4';

        fetch("{{ route('api.refresh.weather') }}")
            .then(res => res.json())
            .then(data => {
                container.style.opacity = '1';
                if (data.success) {
                    iconElement.innerText = '🌤️';
                    // Re-render structural column fields instantly inside the page layout
                    container.innerHTML = `
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100"><span class="block text-[10px] text-gray-400 uppercase font-semibold">Temperature</span><span class="text-base font-bold text-gray-800">${data.weatherData.temperature_2m}°C</span></div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100"><span class="block text-[10px] text-gray-400 uppercase font-semibold">Feels Like</span><span class="text-base font-bold text-gray-800">${data.weatherData.apparent_temperature}°C</span></div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100"><span class="block text-[10px] text-gray-400 uppercase font-semibold">Humidity</span><span class="text-base font-bold text-gray-800">${data.weatherData.relative_humidity_2m}%</span></div>
                            <div class="bg-gray-50 p-2.5 rounded-lg border border-gray-100"><span class="block text-[10px] text-gray-400 uppercase font-semibold">Wind Vector</span><span class="text-base font-bold text-gray-800">${data.weatherData.wind_speed_10m} km/h</span></div>
                        </div>`;
                } else {
                    iconElement.innerText = '⚠️';
                    container.innerHTML = `<p class="text-xs text-red-500 font-mono font-medium bg-red-50 p-2 rounded border border-red-100">${data.weatherError}</p>`;
                }
            })
            .catch(() => {
                container.style.opacity = '1';
            });
    });
});
</script>
@endsection
