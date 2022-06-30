<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Category $category = null)
    {
        $transactions = Transaction::with('category')
            ->when($category, function ($query) use ($category) {
                $query->where('category_id', $category->id);
            })
            ->get();

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}
