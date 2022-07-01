@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-end">
                            <div class="col-md-2">
                                <form id="months-form">
                                    <select name="month" id="month" class="form-select" onchange="document.getElementById('months-form').submit()">
                                        @php
                                            $months = [
                                                'Jan' => 'January',
                                                'Feb' => 'February',
                                                'Mar' => 'March',
                                                'Apr' => 'April',
                                                'May' => 'May',
                                                'Jun' => 'June',
                                                'Jul' => 'July',
                                                'Aug' => 'August',
                                                'Sep' => 'September',
                                                'Oct' => 'October',
                                                'Nov' => 'November',
                                                'Dec' => 'December',
                                            ];
                                        @endphp
                                        @foreach($months as $mon => $month)
                                            <option value="{{ $mon }}" @selected($currentMonth === $mon)>{{ $month }}</option>
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Description</th>
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <td>{{ $transaction->created_at->format('m/d/Y') }}</td>
                                        <td>
                                            <a href="{{ route('transactions.edit', $transaction) }}">{{ $transaction->description }}</a>
                                        </td>
                                        <td>{{ $transaction->category->name }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>
                                            <x-form action="{{ route('transactions.destroy', $transaction) }}" method="delete">
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure?')">Remove</button>
                                            </x-form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $transactions->withQueryString()->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
