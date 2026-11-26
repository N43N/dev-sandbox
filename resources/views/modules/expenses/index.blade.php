@extends('layouts.sandbox')

@section('title', 'Expense Analytics Matrix')

@section('content')
        <div class="max-w-6xl mx-auto space-y-6 p-2">
            
            <!-- Header -->
            <div class="border-b border-gray-200 pb-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">💰 Expense Tracker & Analytics Chart</h1>
                    <p class="text-sm text-gray-500 mt-0.5">Eloquent SQL aggregation (GROUP BY & SUM) piped directly into Chart.js.</p>
                </div>
        
                <div class="flex flex-wrap items-center gap-3">
            <a href="{{ route('expenses.export') }}"
                class="inline-flex items-center gap-1.5 rounded-xl bg-emerald-600 px-4 py-2.5 text-xs font-bold text-white shadow-xs hover:bg-emerald-500 transition">
                <span>Export CSV</span>
                <span>&darr;</span>
            </a>

            <div class="bg-indigo-50 border border-indigo-100 px-4 py-2 rounded-xl text-right">
                <span class="text-[10px] font-bold uppercase tracking-wider text-indigo-500 block">Total Logged Spending</span>
                <span class="text-xl font-black text-indigo-900">RM {{ number_format($totalSpent, 2) }}</span>
            </div>


            <!-- Flash Message -->
            @if(session('status_success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 p-3.5 rounded-xl text-xs font-semibold">
                    ✅ {{ session('status_success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">
                
                <!-- Left Column: Add Expense Form -->
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm space-y-4">
                    <h2 class="font-bold text-gray-800 text-base">Log New Transaction</h2>
                    
                    <form action="{{ route('expenses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Description</label>
                            <input type="text" name="title" placeholder="e.g., Nasi Lemak & Teh Tarik" required
                                class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Category</label>
                                <select name="category" class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                                    <option value="Food & Dining">🍔 Food & Dining</option>
                                    <option value="Transport">🚗 Transport</option>
                                    <option value="Tech & Software">💻 Tech & Software</option>
                                    <option value="Bills & Utilities">⚡ Bills & Utilities</option>
                                    <option value="Entertainment">🎮 Entertainment</option>
                                    <option value="Others">Others</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Amount (RM)</label>
                                <input type="number" step="0.01" name="amount" placeholder="15.50" required
                                    class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-600 uppercase mb-1">Date</label>
                            <input type="date" name="spent_at" value="{{ date('Y-m-d') }}" required
                                class="w-full rounded-xl border-gray-200 text-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-xs py-3 rounded-xl shadow-xs transition">
                            + Add Expense Entry
                        </button>
                    </form>
                </div>

                <!-- Middle Column: Chart.js Visualization -->
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm flex flex-col items-center justify-center min-h-[340px]">
                    <h2 class="font-bold text-gray-800 text-base self-start mb-4">Spending by Category</h2>
                    
                    @if($expenses->count() > 0)
                        <div class="w-full max-w-[260px]">
                            <canvas id="expenseDoughnutChart"></canvas>
                        </div>
                    @else
                        <div class="text-center text-gray-400 py-12 space-y-2">
                            <span class="text-3xl block">📊</span>
                            <p class="text-xs">Log your first expense to generate the live chart.</p>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Recent Transactions Ledger -->
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-sm space-y-4">
                    <h2 class="font-bold text-gray-800 text-base">Recent Transactions</h2>
                    
                    <div class="divide-y divide-gray-100 max-h-[320px] overflow-y-auto pr-1">
                        @forelse($expenses as $expense)
                            <div class="py-3 flex items-center justify-between gap-2">
                                <div>
                                    <p class="text-sm font-bold text-gray-800">{{ $expense->title }}</p>
                                    <p class="text-[11px] text-gray-400">{{ $expense->category }} &bull; {{ $expense->spent_at }}</p>
                                </div>
                                <div class="flex items-center gap-3">
                                    <span class="text-xs font-black text-slate-700">RM {{ number_format($expense->amount, 2) }}</span>
                                    <form action="{{ route('expenses.destroy', $expense) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-gray-300 hover:text-rose-500 text-xs font-bold transition" title="Delete">✕</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 py-6 text-center">No transactions recorded yet.</p>
                        @endforelse
                    </div>
                </div>

            </div>
        </div>

        <!-- Chart.js CDN & Blade Data Injection -->
    @if($expenses->count() > 0)
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const ctx = document.getElementById('expenseDoughnutChart').getContext('2d');
                
                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: @json($chartLabels),
                        datasets: [{
                            data: @json($chartData),
                            backgroundColor: [
                                '#4f46e5',
                                '#10b981',
                                '#f59e0b',
                                '#ec4899',
                                '#06b6d4'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff'
                        }]
                    },
                    options: {
                        responsive: true,
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    boxWidth: 12,
                                    font: { size: 11 }
                                }
                            }
                        }
                    }
                });
            });
        </script>
    @endif
@endsection
