<?php

namespace App\Http\Controllers\ExpenseModule;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        // 1. Fetch recent expenses list
        $expenses = Expense::where('user_id', $userId)
            ->orderByDesc('spent_at')
            ->orderByDesc('id')
            ->get();

        // 2. Calculate total overall spending
        $totalSpent = $expenses->sum('amount');

        // 3. Aggregate totals grouped by category for Chart.js
        $categoryTotals = Expense::where('user_id', $userId)
            ->select('category', DB::raw('SUM(amount) as total'))
            ->groupBy('category')
            ->pluck('total', 'category');

        return view('modules.expenses.index', [
            'expenses'       => $expenses,
            'totalSpent'     => $totalSpent,
            'chartLabels'    => $categoryTotals->keys(),
            'chartData'      => $categoryTotals->values(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'    => 'required|string|max:100',
            'category' => 'required|string|max:50',
            'amount'   => 'required|numeric|min:0.01|max:999999.99',
            'spent_at' => 'required|date',
        ]);

        Expense::create([
            'user_id'  => auth()->id(),
            'title'    => $validated['title'],
            'category' => $validated['category'],
            'amount'   => $validated['amount'],
            'spent_at' => $validated['spent_at'],
        ]);

        return back()->with('status_success', 'Expense logged and chart updated!');
    }

    public function destroy(Expense $expense)
    {
        // Security check: ensure user only deletes their own records
        if ($expense->user_id !== auth()->id()) {
            abort(403);
        }

        $expense->delete();

        return back()->with('status_success', 'Expense entry deleted.');
    }

        public function exportCsv()
    {
        $expenses = Expense::where('user_id', auth()->id())
            ->orderByDesc('spent_at')
            ->orderByDesc('id')
            ->get();

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="expenses-' . now()->format('Y-m-d') . '.csv"',
        ];

        $callback = function () use ($expenses) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'Title', 'Category', 'Amount (RM)']);

            foreach ($expenses as $expense) {
                fputcsv($file, [
                    $expense->spent_at,
                    $expense->title,
                    $expense->category,
                    number_format((float) $expense->amount, 2, '.', ''),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

}
