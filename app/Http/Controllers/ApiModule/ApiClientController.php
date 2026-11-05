<?php

namespace App\Http\Controllers\ApiModule;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiClientController extends Controller
{
    public function index(Request $request)
    {
        // 📡 API 1: Fetch randomized advice (FIXED URL path)
        $advice = 'Keep your code clean, modular, and well-tested.';
        try {
            $adviceResponse = Http::timeout(5)->withoutVerifying()->get('https://adviceslip.com');
            if ($adviceResponse->successful()) {
                $jsonData = $adviceResponse->json();
                if (isset($jsonData['slip']['advice'])) {
                    $advice = $jsonData['slip']['advice'];
                }
            }
        } catch (\Exception $e) {
            $advice = 'Advice Connection Error: ' . substr($e->getMessage(), 0, 40);
        }

        // 📡 API 2: Dynamic IP Geolocation Lookup (FIXED json endpoint)
        $locationName = 'Detecting Location...';
        $latitude = 2.8125;
        $longitude = 101.7975;

        try {
            $geoResponse = Http::timeout(5)->withoutVerifying()->get('https://ipapi.co');
            if ($geoResponse->successful()) {
                $geoData = $geoResponse->json();
                if (!empty($geoData['city'])) {
                    $locationName = $geoData['city'] . ', ' . ($geoData['country_name'] ?? 'Malaysia');
                    $latitude = $geoData['latitude'] ?? $latitude;
                    $longitude = $geoData['longitude'] ?? $longitude;
                }
            }
        } catch (\Exception $e) {
            $locationName = 'Location Error: ' . substr($e->getMessage(), 0, 30);
        }

        // 📡 API 3: Weather Forecast Stream (FIXED API Subdomain URL)
        $weatherData = null;
        $weatherError = 'Initial connection setup...';
        
        try {
            $weatherResponse = Http::timeout(5)->withoutVerifying()->get('https://open-meteo.com', [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'current' => 'temperature_2m,relative_humidity_2m,apparent_temperature,wind_speed_10m',
                'timezone' => 'auto'
            ]);

            if ($weatherResponse->successful()) {
                $weatherData = $weatherResponse->json()['current'] ?? null;
            } else {
                $weatherError = 'Server Status Error Code: ' . $weatherResponse->status();
            }
        } catch (\Exception $e) {
            $weatherError = 'Connection Bug: ' . substr($e->getMessage(), 0, 60);
        }

        return view('modules.api.index', compact('advice', 'weatherData', 'locationName', 'weatherError'));
    }

       // 🔄 Card Action 1: Isolated Live Advice Stream Fetcher (FIXED HTTPS API Subdomain)
    public function refreshAdvice()
    {
        $advice = 'Keep your code clean, modular, and well-tested.';
        try {
            $adviceResponse = Http::timeout(4)->withoutVerifying()->get('https://adviceslip.com');
            if ($adviceResponse->successful()) {
                $jsonData = $adviceResponse->json();
                if (isset($jsonData['slip']['advice'])) {
                    $advice = $jsonData['slip']['advice'];
                }
            }
        } catch (\Exception $e) {
            $advice = 'Advice Connection Error: ' . substr($e->getMessage(), 0, 40);
        }

        return response()->json(['advice' => $advice]);
    }

    // 🔄 Card Action 2: Isolated Weather Telemetry Array Fetcher (FIXED Full API Route)
    public function refreshWeather(Request $request)
    {
        $latitude = $request->input('latitude', 2.8125);
        $longitude = $request->input('longitude', 101.7975);
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


}
