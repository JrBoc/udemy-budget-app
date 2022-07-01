<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionRequest;
use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Support\MessageBag;


class TransactionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Category $category)
    {
        $transactions = Transaction::with('category')->byCategory($category)->get();

        return view('transactions.index', [
            'transactions' => $transactions,
        ]);
    }

    public function create()
    {
        return view('transactions.create', [
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function store(TransactionRequest $request)
    {
        Transaction::create($request->all());

        return to_route('transactions.index');
    }

    public function edit(Transaction $transaction)
    {
        return view('transactions.edit', [
            'transaction' => $transaction,
            'categories' => Category::pluck('name', 'id'),
        ]);
    }

    public function update(TransactionRequest $request, Transaction $transaction)
    {
        $transaction->update($request->all());

        return to_route('transactions.index');
    }
}
