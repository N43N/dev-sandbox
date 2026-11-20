@extends('layouts.sandbox')

@section('content')
<link rel="stylesheet" href="https://jsdelivr.net" />

<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-wrap items-center justify-between gap-4 border-b border-slate-200 pb-4">
        <div>
            <h1 class="text-2xl font-bold text-slate-900">Geospatial & Coordinate Pin Sandbox</h1>
            <p class="text-sm text-slate-500">Click anywhere on the map to capture coordinates and save pins.</p>
        </div>
        <button type="button" onclick="resetMap()"
                class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-xs font-medium text-slate-700 hover:bg-slate-50">
            Center on Nilai
        </button>
    </div>

    @if (session('status'))
        <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
            {{ session('status') }}
        </div>
    @endif

    {{-- Main 3-Column Grid --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left 2 Columns: Interactive Map --}}
        <div class="lg:col-span-2 space-y-3">

        {{-- Place Search Bar --}}
        <div class="flex gap-2">
            <input type="text" id="place-search" placeholder="Search place or building (e.g. MAP2U Sdn Bhd, AEON Mall Nilai)..."
                onkeydown="if(event.key === 'Enter'){ event.preventDefault(); searchPlace(); }"
                class="flex-1 rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm shadow-xs focus:border-indigo-500 focus:outline-none">
            <button type="button" onclick="searchPlace()"
                    class="rounded-lg bg-slate-800 px-4 py-2 text-xs font-semibold text-white hover:bg-slate-700">
                Search
            </button>
        </div>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                <div id="map" style="height: 480px; width: 100%;" class="z-0"></div>
            </div>

            {{-- Simple Legend --}}
            <div class="flex flex-wrap gap-4 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-xs text-slate-600">
                <span class="font-semibold text-slate-800">Legend:</span>
                <span><b class="text-blue-600">●</b> Office</span>
                <span><b class="text-emerald-600">●</b> Landmark</span>
                <span><b class="text-amber-500">●</b> Infrastructure</span>
                <span><b class="text-purple-600">●</b> Client Site</span>
                <span><b class="text-rose-500">●</b> Preview Pin</span>
            </div>
        </div>

        {{-- Right Column: Form + Saved Pins List --}}
        <div class="space-y-6">
            {{-- Create Pin Form --}}

            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-semibold text-slate-900 mb-3">Add Coordinate Pin</h2>

                <form method="POST" action="{{ route('gis.store') }}" class="space-y-3">
                    @csrf

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Title</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" required
                            placeholder="Click map or search to auto-fill..."
                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">

                        @error('title') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Category</label>
                        <select name="category" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm bg-white">
                            @foreach ($categories as $category)
                                <option value="{{ $category }}" @selected(old('category') === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Latitude</label>
                            <input type="number" step="0.0000001" id="latitude" name="latitude"
                                value="{{ old('latitude', '2.8185000') }}" required
                                class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 font-mono text-xs">
                            @error('latitude') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-slate-700 mb-1">Longitude</label>
                            <input type="number" step="0.0000001" id="longitude" name="longitude"
                                value="{{ old('longitude', '101.7972000') }}" required
                                class="w-full rounded-lg border border-slate-300 bg-slate-50 px-3 py-2 font-mono text-xs">
                            @error('longitude') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-slate-700 mb-1">Notes (Optional)</label>
                        <textarea name="notes" rows="2" placeholder="Remarks..."
                                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm">{{ old('notes') }}</textarea>
                        @error('notes') <p class="text-xs text-rose-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit"
                            class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">
                        Save Pin
                    </button>
                </form>
            </div>

            {{-- Saved Pins List --}}
            <div class="rounded-xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="text-base font-semibold text-slate-900 mb-3">
                    Saved Pins ({{ $locations->count() }})
                </h2>

                @if ($locations->isEmpty())
                    <p class="text-xs text-slate-500 text-center py-4">No pins saved yet.</p>
                @else
                    <div class="max-h-72 space-y-2 overflow-y-auto">
                        @foreach ($locations as $loc)
                            <div class="flex items-start justify-between gap-2 rounded-lg border border-slate-200 p-2.5 hover:bg-slate-50">
                                <button type="button" onclick="flyToPin({{ $loc->id }})" class="text-left flex-1">
                                    <p class="text-sm font-semibold text-slate-900">{{ $loc->title }}</p>
                                    <p class="text-[11px] text-indigo-600 font-medium">{{ $loc->category }}</p>
                                    <p class="font-mono text-[11px] text-slate-500">
                                        {{ number_format($loc->latitude, 5) }}, {{ number_format($loc->longitude, 5) }}
                                    </p>
                                </button>

                                <form method="POST" action="{{ route('gis.destroy', $loc) }}"
                                    onsubmit="return confirm('Delete this pin?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-xs text-rose-600 hover:underline px-1">Delete</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    let map;
    const NILAI_COORDS = [2.8185, 101.7972];
    const markers = {};
    let previewPin = null;

    window.addEventListener('load', function () {
        map = L.map('map').setView(NILAI_COORDS, 14);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        const colors = {
            'Office': '#2563eb',
            'Landmark': '#059669',
            'Infrastructure': '#f59e0b',
            'Client Site': '#9333ea'
        };

        const locations = @json($locations);

        // Plot saved pins with "Open in Google Maps" link
        locations.forEach(loc => {
            const marker = L.circleMarker([loc.latitude, loc.longitude], {
                radius: 8,
                fillColor: colors[loc.category] || '#475569',
                color: '#ffffff',
                weight: 2,
                fillOpacity: 0.9
            }).addTo(map);

            const gmapsUrl = `https://google.com{loc.latitude},${loc.longitude}`;

            marker.bindPopup(`
                <b>${loc.title}</b><br>
                <small>${loc.category}</small><br>
                <code>${loc.latitude.toFixed(5)}, ${loc.longitude.toFixed(5)}</code>
                ${loc.notes ? `<p style="margin-top:4px;font-size:12px;">${loc.notes}</p>` : ''}
                <div style="margin-top:6px;">
                    <a href="${gmapsUrl}" target="_blank" rel="noopener noreferrer"
                        style="color:#2563eb;font-size:11px;font-weight:600;text-decoration:underline;">
                        Open in Google Maps &nearr;
                    </a>
                </div>
            `);

            markers[loc.id] = marker;
        });

        // Click map -> capture coordinates + auto-detect building/street name
        map.on('click', async function (e) {
            const lat = e.latlng.lat.toFixed(7);
            const lng = e.latlng.lng.toFixed(7);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
            document.getElementById('title').value = 'Detecting place name...';

            updatePreviewPin(e.latlng, 'Detecting place...');

            try {
                const res = await fetch(`https://openstreetmap.org{lat}&lon=${lng}`);
                const data = await res.json();
                const placeName = data.name || data.address?.building || data.address?.amenity || data.address?.road || 'Pinned Location';

                document.getElementById('title').value = placeName;
                updatePreviewPin(e.latlng, placeName);
            } catch (err) {
                document.getElementById('title').value = 'Pinned Location';
                updatePreviewPin(e.latlng, 'New Pin Preview');
            }
        });
    });

    async function searchPlace() {
        const query = document.getElementById('place-search').value.trim();
        if (!query || !map) return;

        try {
            const res = await fetch(`https://openstreetmap.org{encodeURIComponent(query)}`);
            const results = await res.json();

            if (!results.length) {
                alert('Location not found. Try a broader building or area name.');
                return;
            }

            const place = results;
            const lat = parseFloat(place.lat);
            const lng = parseFloat(place.lon);
            const shortName = place.display_name.split(',');

            document.getElementById('title').value = shortName;
            document.getElementById('latitude').value = lat.toFixed(7);
            document.getElementById('longitude').value = lng.toFixed(7);

            map.flyTo([lat, lng], 16);
            updatePreviewPin([lat, lng], shortName);
        } catch (err) {
            alert('Search failed. Please check your internet connection.');
        }
    }

    function updatePreviewPin(latlng, label) {
        const lat = Array.isArray(latlng) ? latlng : latlng.lat;
        const lng = Array.isArray(latlng) ? latlng : latlng.lng;

        if (previewPin) {
            previewPin.setLatLng([lat, lng]);
        } else {
            previewPin = L.circleMarker([lat, lng], {
                radius: 8,
                fillColor: '#f43f5e',
                color: '#ffffff',
                weight: 2,
                fillOpacity: 0.9
            }).addTo(map);
        }

        previewPin.bindPopup(`<b>${label}</b><br><code>${Number(lat).toFixed(5)}, ${Number(lng).toFixed(5)}</code>`).openPopup();
    }

    function flyToPin(id) {
        if (!map || !markers[id]) return;
        map.flyTo(markers[id].getLatLng(), 16);
        markers[id].openPopup();
    }

    function resetMap() {
        if (!map) return;
        map.flyTo(NILAI_COORDS, 14);
    }
</script>
@endsection