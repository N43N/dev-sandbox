<?php

namespace App\Http\Controllers\ApiModule;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Stevebauman\Location\Facades\Location;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;


class ApiClientController extends Controller
{
    public function index(Request $request)
    {
        // 1. Detect Location & Coordinates via Stevebauman Location Library
        $position = Location::get($request->ip());

        $locationName = $position 
            ? $position->cityName . ', ' . $position->countryName 
            : 'Nilai, Malaysia';
        
        $latitude  = $position ? $position->latitude : 2.8125;
        $longitude = $position ? $position->longitude : 101.7975;

        // 2. Fetch Cached Advice Slip
        $advice = Cache::remember('daily_advice_slip', now()->addMinutes(10), function () {
            try {
                $response = Http::timeout(5)->withoutVerifying()->get('https://adviceslip.com');
                if ($response->successful()) {
                    return $response->json()['slip']['advice'] ?? 'Keep your code clean, modular, and well-tested.';
                }
            } catch (\Exception $e) {
                return 'Keep your code clean, modular, and well-tested.';
            }
            return 'Keep your code clean, modular, and well-tested.';
        });

        // 3. Fetch Cached Weather Stream (Matches all 4 Blade fields)
        $weatherError = null;
        $cacheKey = 'weather_' . round($latitude, 2) . '_' . round($longitude, 2);

        $weatherData = Cache::remember($cacheKey, now()->addMinutes(30), function () use ($latitude, $longitude, &$weatherError) {
            try {
                $response = Http::timeout(5)->withoutVerifying()->get('https://open-meteo.com', [
                    'latitude' => $latitude,
                    'longitude' => $longitude,
                    'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,wind_speed_10m',
                    'timezone' => 'auto'
                ]);

                if ($response->successful()) {
                    return $response->json()['current'] ?? null;
                }
                $weatherError = 'Server Status Error Code: ' . $response->status();
            } catch (\Exception $e) {
                $weatherError = 'Connection Bug: ' . substr($e->getMessage(), 0, 60);
            }
            return null;
        });

        if (!$weatherData && !$weatherError) {
            $weatherError = 'Weather telemetry currently unavailable.';
        }

        return view('modules.api.index', compact('advice', 'weatherData', 'locationName', 'weatherError'));
    }

    // Card Action 1: Isolated Live Advice Stream Fetcher
    public function refreshAdvice()
    {
        Cache::forget('daily_advice_slip');
        $advice = 'Keep your code clean, modular, and well-tested.';

        try {
            $adviceResponse = Http::timeout(4)->withoutVerifying()->get('https://adviceslip.com');
            if ($adviceResponse->successful()) {
                $jsonData = $adviceResponse->json();
                if (isset($jsonData['slip']['advice'])) {
                    $advice = $jsonData['slip']['advice'];
                    Cache::put('daily_advice_slip', $advice, now()->addMinutes(10));
                }
            }
        } catch (\Exception $e) {
            $advice = 'Advice Connection Error: ' . substr($e->getMessage(), 0, 40);
        }

        return response()->json(['advice' => $advice]);
    }

    // Card Action 2: Isolated Weather Telemetry Array Fetcher
    public function refreshWeather(Request $request)
    {
        $position = Location::get($request->ip());
        $latitude  = $request->input('latitude', $position ? $position->latitude : 2.8125);
        $longitude = $request->input('longitude', $position ? $position->longitude : 101.7975);
        
        $weatherData = null;
        $weatherError = null;

        try {
            $weatherResponse = Http::timeout(4)->withoutVerifying()->get('https://open-meteo.com', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,wind_speed_10m',
                'timezone' => 'auto'
            ]);

            if ($weatherResponse->successful()) {
                $weatherData = $weatherResponse->json()['current'] ?? null;
                if ($weatherData) {
                    $cacheKey = 'weather_' . round($latitude, 2) . '_' . round($longitude, 2);
                    Cache::put($cacheKey, $weatherData, now()->addMinutes(30));
                }
            } else {
                $weatherError = 'HTTP Code: ' . $weatherResponse->status();
            }
        } catch (\Exception $e) {
            $weatherError = 'Connection Bug: ' . substr($e->getMessage(), 0, 40);
        }

        return response()->json([
            'success' => !is_null($weatherData),
            'weatherData' => $weatherData,
            'weatherError' => $weatherError
        ]);
    }

    // 💵 API Extension: Live Currency Converter Matrix
public function currencyIndex(Request $request)
    {
        $exchangeRates = null;
        $exchangeError = null;
        
        $amount = max(0.01, (float) $request->input('amount', 100));
        $fromCurrency = $request->input('from', 'USD');
        $toCurrency = $request->input('to', 'MYR');
        $convertedAmount = 0.00;

        try {
            // Fetch live real-time currency ratios relative to our chosen "From" base currency
            $response = Http::timeout(5)
                ->withoutVerifying()
                ->get("https://er-api.com{$fromCurrency}");

            if ($response->successful()) {
                $data = $response->json();
                $exchangeRates = $data['rates'] ?? null;
                
                if (isset($exchangeRates[$toCurrency])) {
                    $convertedAmount = $amount * $exchangeRates[$toCurrency];
                }
            } else {
                $exchangeError = 'Currency server responded with code: ' . $response->status();
            }
        } catch (\Exception $e) {
            $exchangeError = 'Connection failed: ' . substr($e->getMessage(), 0, 50);
        }

        // 🔀 FALLBACK BLOCK: If local machine is offline, supply standard codes
        if (!$exchangeRates) {
            $exchangeRates = [
                'USD' => 1.0000, 'MYR' => 4.4250, 'EUR' => 0.9210, 'GBP' => 0.7730,
                'JPY' => 152.30, 'SGD' => 1.3220, 'IDR' => 15720.00, 'AUD' => 1.5180,
                'CAD' => 1.3890, 'CNY' => 7.1200, 'INR' => 84.0500, 'THB' => 33.8000
            ];
            
            if (isset($exchangeRates[$toCurrency])) {
                $baseRate = $exchangeRates[$fromCurrency] ?? 1.0;
                $targetRate = $exchangeRates[$toCurrency];
                $convertedAmount = ($amount / $baseRate) * $targetRate;
            }
        }

        // 🧠 AUTOMATIC GLOBAL EXTRACTION: Extract all 160+ keys from the live internet packet
        $availableCurrencies = array_keys($exchangeRates);
        sort($availableCurrencies); // 🔤 Sort completely by alphabet (A to Z)

        return view('modules.api.currency', compact(
            'amount',
            'fromCurrency',
            'toCurrency',
            'convertedAmount',
            'exchangeRates',
            'exchangeError',
            'availableCurrencies'
        ));
    }

        // ✉️ Email Verification Lab: Render the workspace view
    public function emailVerifyIndex()
    {
        return view('modules.api.email_verify');
    }

    // ✉️ Email Verification Lab: Generate signed URL and dispatch mock mail
    public function sendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        $email = $request->input('email');

        // 🔒 Generate a secure cryptographic link valid for exactly 30 minutes
        $verificationUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
            'email.verify.confirm',
            now()->addMinutes(30),
            ['email' => $email]
        );

        try {
            // Dispatches the customizable Markdown Mailable directly to your local mail catcher
            \Illuminate\Support\Facades\Mail::to($email)->send(new \App\Mail\SandboxVerifyEmail($verificationUrl, $email));
            
            return redirect()->route('email.verify.index')->with('status_info', "Secure link dispatched! Check your test inbox dashboard at http://localhost:8025");
        } catch (\Exception $e) {
            return redirect()->route('email.verify.index')->with('status_error', "Mail configuration mismatch: " . substr($e->getMessage(), 0, 60));
        }
    }

    // ✉️ Email Verification Lab: Handle the secure signed callback link landing
    public function confirmVerification(Request $request, $email)
    {
        // If the URL signature was manipulated or expired, Laravel automatically aborts before getting here.
        return redirect()->route('email.verify.index')->with('status_success', "Verification complete successfully for: {$email}");
    }

    // 🎨 Profile Designer: Render empty state / default fallback workspace
    public function profileDesignerIndex()
    {
        // Fetch existing state from session, default to layout fallback
        $profile = session('profile_card_state', [
            'name' => auth()->user()->name,
            'title' => 'First Time Learner',
            'bio' => 'Write a short, engaging description about your core skillsets, developer toolkit, or personal projects here.',
            'url' => 'https://github.com/N43N',
            'avatar' => null // Fallback placeholder asset
        ]);

        return view('modules.api.profile_designer', compact('profile'));
    }

    // Profile Designer: Extract parameters, process image upload, and sync states
    public function profileDesignerGenerate(Request $request)
    {
        $validated = $request->validate([
            'name'   => 'required|string|max:50',
            'title'  => 'required|string|max:60',
            'bio'    => 'required|string|max:160',
            'url'    => 'required|url',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' // Max 2MB configuration
        ]);

        // Retain old avatar path if no new one is uploaded
        $currentState = session('profile_card_state', []);
        $avatarPath = $currentState['avatar'] ?? null;

        if ($request->hasFile('avatar')) {
            // Delete old avatar file from disk if it exists to save space
            if ($avatarPath && Storage::disk('public')->exists(str_replace('/storage/', '', $avatarPath))) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $avatarPath));
            }
            
            // Store image natively in public avatars directory
            $path = $request->file('avatar')->store('avatars', 'public');
            $avatarPath = Storage::url($path);
        }

        $profileData = [
            'name'   => $validated['name'],
            'title'  => $validated['title'],
            'bio'    => $validated['bio'],
            'url'    => $validated['url'],
            'avatar' => $avatarPath
        ];

        // Store state systematically in session for global dashboard access
        session(['profile_card_state' => $profileData]);

        return redirect()->back()->with('status_success', 'Profile Card state synchronized successfully!');
    }
        // 📊 Dashboard: Serve the persistent profile card state matrix
    public function dashboardIndex()
    {
        $profile = session('profile_card_state', [
            'name' => auth()->user()->name,
            'title' => 'First Time Learner',
            'bio' => 'Write a short, engaging description about your core skillsets, developer toolkit, or personal projects here.',
            'url' => 'https://github.com/N43N',
            'avatar' => null
        ]);

        return view('dashboard', compact('profile'));
    }

}
