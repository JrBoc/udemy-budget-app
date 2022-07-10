<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRequest;
use App\Models\Budget;
use App\Models\Category;
use Carbon\Carbon;

class BudgetController extends Controller
{
    public function index()
    {
        return view('budgets.index', [
            'budgets' => Budget::byMonth($currentMonth = request('month') ? : now()->format('M'))->paginate(),
            'currentMonth' => $currentMonth,
        ]);
    }

    public function create()
    {
        return view('budgets.create', [
            'categories' => Category::pluck('name', 'id'),
            'currentMonth' => request('month') ? : now()->format('M'),
        ]);
    }

    public function store(BudgetRequest $request)
    {
        Budget::create($request->safe([
            'amount',
            'category_id',
            'budget_date',
        ]));

        return to_route('budgets.index');
    }

    public function edit(Budget $budget)
    {
        return view('budgets.edit', [
            'budget' => $budget,
            'categories' => Category::pluck('name', 'id'),
            'currentMonth' => $budget->budget_date->format('M'),
        ]);
    }

    public function update(BudgetRequest $request, Budget $budget)
    {
        $budget->update($request->safe([
            'amount',
            'category_id',
            'budget_date',
        ]));

        return to_route('budgets.index');
    }

    public function destroy(Budget $budget)
    {
        $budget->delete();

        return to_route('budgets.index');
    }
}
