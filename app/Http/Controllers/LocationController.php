<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LocationController extends Controller
{
    private const CATEGORIES = ['Office', 'Landmark', 'Infrastructure', 'Client Site'];

    public function index(): View
    {
        return view('modules.gis.index', [
            'locations' => auth()->user()->locations()->latest()->get(),
            'categories' => self::CATEGORIES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', Rule::in(self::CATEGORIES)],
            'latitude' => ['required', 'numeric', 'between:-90,90'],
            'longitude' => ['required', 'numeric', 'between:-180,180'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        auth()->user()->locations()->create($validated);

        return redirect()->route('gis.index')->with('status', 'Pin saved.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        abort_if($location->user_id !== auth()->id(), 403);

        $location->delete();

        return redirect()->route('gis.index')->with('status', 'Pin deleted.');
    }
}
