<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransactionStoreRequest;
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

    public function store(TransactionStoreRequest $request)
    {
        Transaction::create($request->all());

        return to_route('transactions.index');
    }
}
