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
}
