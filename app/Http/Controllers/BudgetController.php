<?php

namespace App\Http\Controllers;

use App\Http\Requests\BudgetRequest;
use App\Models\Budget;

class BudgetController extends Controller
{
    public function index()
    {
        return view('budgets.index', [
            'budgets' => Budget::byMonth($currentMonth = request('month') ? : now()->format('M'))->paginate(),
            'currentMonth' => $currentMonth,
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
}
