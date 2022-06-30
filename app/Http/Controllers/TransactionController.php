<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function index(Category $category)
    {
        $transactions = Transaction::with('category')->byCategory($category)->get();

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }
}
