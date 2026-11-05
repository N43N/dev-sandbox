@extends('layouts.sandbox')

@section('title', 'Global Currency Matrix')

@section('content')
<div class="space-y-6 max-w-7xl mx-auto p-2">
    
    <!-- Header Unit -->
    <div class="border-b border-gray-200 pb-4">
        <h1 class="text-2xl font-bold text-gray-900">💵 Global Currency Exchange Laboratory</h1>
        <p class="text-sm text-gray-500 mt-0.5">Processing dynamic floating-point conversion ratios across 160+ alphabetized world assets.</p>
    </div>

    <!-- Main Laboratory Workspace Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Column 1 & 2: Interactive Calculator Panel -->
        <div class="lg:col-span-2 bg-white border border-gray-200 p-6 rounded-2xl shadow-sm space-y-6">
            <h2 class="text-sm font-bold uppercase tracking-wider text-indigo-600">⚡ Dynamic Live Conversion</h2>
            
            <form action="{{ route('api.currency') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 items-end">
                <!-- Amount Input Box -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Amount</label>
                    <input type="number" name="amount" step="0.01" min="0.01" value="{{ $amount }}" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2 text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- From Selector (All World Currencies, Sorted A-Z) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">From</label>
                    <select name="from" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($availableCurrencies as $code)
                            <option value="{{ $code }}" {{ $fromCurrency == $code ? 'selected' : '' }}>{{ $code }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- To Selector (All World Currencies, Sorted A-Z) -->
                <div>
                    <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">To</label>
                    <select name="to" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach($availableCurrencies as $code)
                            <option value="{{ $code }}" {{ $toCurrency == $code ? 'selected' : '' }}>{{ $code }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Submit Button with Label Spacer -->
                <div>
                    <label class="hidden sm:block text-xs mb-2 invisible">Submit</label>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl shadow-xs transition-all h-[42px] flex items-center justify-center gap-2 group">
                        <span>Convert</span>
                        <span class="transform group-hover:translate-x-1 transition-transform">➔</span>
                    </button>
                </div>
            </form>

            <!-- Big Visual Results Display Box -->
            <div class="bg-slate-900 rounded-2xl p-6 text-white border border-slate-800">
                <span class="text-xs font-bold text-indigo-400 uppercase tracking-widest block">Calculation Outcome</span>
                <div class="mt-3 flex flex-col sm:flex-row sm:items-baseline justify-between gap-2">
                    <div>
                        <span class="text-base text-slate-400 font-medium">{{ number_format($amount, 2) }} {{ $fromCurrency }} =</span>
                        <h3 class="text-3xl font-black tracking-tight text-white mt-1">
                            {{ number_format($convertedAmount, 2) }} <span class="text-indigo-400">{{ $toCurrency }}</span>
                        </h3>
                    </div>
                    @if($exchangeRates && isset($exchangeRates[$toCurrency]))
                        <span class="text-xs font-mono text-slate-400 bg-slate-800 px-3 py-1.5 rounded-lg border border-slate-700">
                            Rate: 1 {{ $fromCurrency }} = {{ number_format($exchangeRates[$toCurrency], 4) }} {{ $toCurrency }}
                        </span>
                    @endif
                </div>
            </div>
        </div>

        <!-- Column 3: Custom Selected Benchmark Tracker Sidebar -->
        <div class="bg-gray-50 border border-gray-200 p-6 rounded-2xl flex flex-col justify-between space-y-6">
            <div>
                <h2 class="text-sm font-bold uppercase tracking-wider text-gray-700 mb-4">📊 Active Pair Tracker</h2>
                
                @if($exchangeRates && isset($exchangeRates[$toCurrency]))
                    <div class="space-y-3">
                        <p class="text-xs text-gray-400 leading-relaxed">Displaying isolated real-time telemetry metrics for your explicitly chosen market conversion exchange parameters:</p>
                        
                        <!-- Main Forward Direct Exchange Pair -->
                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-xs">
                            <div class="text-[10px] uppercase font-bold text-indigo-500 tracking-wider">Direct Conversion</div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs font-bold text-gray-600">1 {{ $fromCurrency }} ➔ {{ $toCurrency }}</span>
                                <span class="text-sm font-mono font-bold text-gray-800">{{ number_format($exchangeRates[$toCurrency], 4) }}</span>
                            </div>
                        </div>

                        <!-- Mathematical Reverse Inverse Exchange Pair -->
                        <div class="bg-white p-3 rounded-xl border border-gray-200 shadow-xs">
                            <div class="text-[10px] uppercase font-bold text-slate-500 tracking-wider">Inverse Ratio</div>
                            <div class="flex justify-between items-center mt-1">
                                <span class="text-xs font-bold text-gray-600">1 {{ $toCurrency }} ➔ {{ $fromCurrency }}</span>
                                <span class="text-sm font-mono font-bold text-gray-800">
                                    {{ $exchangeRates[$toCurrency] > 0 ? number_format(1 / $exchangeRates[$toCurrency], 4) : '0.0000' }}
                                </span>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="bg-red-50 p-4 rounded-xl border border-red-100 text-xs text-red-600 font-mono">
                        ⚠️ {{ $exchangeError ?? 'No data stream loaded.' }}
                    </div>
                @endif
            </div>

            <div class="text-[10px] text-gray-400 border-t border-gray-200 pt-4 font-mono">
                Network: <span class="text-indigo-600">://er-api.com</span>
            </div>
        </div>

    </div>
</div>
@endsection
