@extends('layouts.sandbox')

@section('title', 'Email Verification Lab')

@section('content')
<div class="max-w-2xl mx-auto space-y-6">
    
    <!-- Header Block -->
    <div class="border-b border-gray-200 pb-4">
        <h1 class="text-2xl font-bold text-gray-900">✉️ Email Verification Sandbox Laboratory</h1>
        <p class="text-sm text-gray-500 mt-0.5">Practicing secure temporary signature string generation and inbound validation route handlers.</p>
    </div>

    <!-- 🟢 DYNAMIC ALERT NOTIFICATION PANELS -->
    
    <!-- 1. Custom Requested Bold Green Success Banner -->
    @if(session('status_success'))
        <div class="bg-emerald-50 border-2 border-emerald-500 text-emerald-900 p-4 rounded-xl shadow-xs flex items-start gap-3">
            <span class="text-xl mt-0.5">✅</span>
            <div>
                <h3 class="font-bold text-sm text-emerald-950">Verification Complete Successfully!</h3>
                <p class="text-xs text-emerald-800 mt-1 font-medium">{{ session('status_success') }}</p>
            </div>
        </div>
    @endif

    <!-- 2. Standard Informational Dispatched Status Banner -->
    @if(session('status_info'))
        <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 p-4 rounded-xl text-xs font-medium font-mono">
            ℹ️ {{ session('status_info') }}
        </div>
    @endif

    <!-- 3. Error Fallback Warning Alert Banner -->
    @if(session('status_error'))
        <div class="bg-rose-50 border border-rose-200 text-rose-700 p-4 rounded-xl text-xs font-medium">
            ⚠️ {{ session('status_error') }}
        </div>
    @endif

    <!-- Main Form Interactive Workspace Card -->
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-6">
        <div>
            <h2 class="text-sm font-bold uppercase tracking-wider text-indigo-600">⚡ Dispatch Cryptographic Simulation</h2>
            <p class="text-xs text-gray-400 mt-1">Type an email below. Clicking send skips app database tables completely to isolate the mailer transport layers.</p>
        </div>

        <form action="{{ route('email.verify.send') }}" method="POST" class="space-y-4">
            @csrf
            
            <div>
                <label class="block text-xs font-semibold text-gray-500 uppercase mb-2">Target Email Address</label>
                <input type="email" name="email" required placeholder="you@example.com" class="w-full bg-gray-50 border border-gray-300 rounded-xl px-4 py-2.5 text-gray-900 font-medium focus:outline-none focus:ring-2 focus:ring-indigo-500 @error('email') border-red-500 @enderror">
                @error('email')
                    <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2.5 px-4 rounded-xl shadow-xs transition-all flex items-center justify-center gap-2">
                <span>Send Verification Link</span> ➔
            </button>
        </form>
    </div>

    <!-- Quick Local Infrastructure Tip Panel -->
    <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-[11px] text-gray-500 space-y-1">
        <span class="font-bold text-gray-700 uppercase block tracking-wider">🔬 Local Environment Testing Guidelines:</span>
        <p>1. Make sure your local mail routing services are active inside your Laravel Herd control panel.</p>
        <p>2. Open your web browser connection tool and head to: <a href="http://localhost:8025" target="_blank" class="text-indigo-600 font-semibold underline">http://localhost:8025</a> to watch your Mailpit incoming mailbox activity live.</p>
    </div>

</div>
@endsection
