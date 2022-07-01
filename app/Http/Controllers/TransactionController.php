<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;


class TransactionController extends Controller
{
    public function index(Category $category)
    {
        $transactions = Transaction::with('category')->byCategory($category)->get();

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    public function store(Request $request)
    {
        Transaction::create($request->all());

        return to_route('transactions.index');
    }
}
