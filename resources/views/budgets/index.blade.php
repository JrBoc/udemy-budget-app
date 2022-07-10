@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row justify-content-between">
                            <div class="col-md-2">
                                <h4>Monthly Budget</h4>
                            </div>
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
                                    <th>Category</th>
                                    <th>Amount</th>
                                    <th>Balance</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($budgets as $budget)
                                    <tr>
                                        <td>
                                            <a href="{{ route('budgets.edit', $budget) }}">{{ $budget->category->name }}</a>
                                        </td>

                                        <td>{{ $budget->amount }}</td>
                                        <td>{{ $budget->balance() }}</td>
                                        <td>
                                            <x-form action="{{ route('budgets.destroy', $budget) }}" method="delete">
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure?')">Remove</button>
                                            </x-form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $budgets->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
