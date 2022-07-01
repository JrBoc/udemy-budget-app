@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Create Transaction
                    </div>
                    <div class="card-body">
                        <form action="{{ route('transactions.store') }}" method="post">
                            @csrf
                            <div class="form-group mb-3">
                                <label for="description">Description</label>
                                <input type="text" name="description" class="form-control {{ is_invalid($errors, 'description') }}" value="{{ old('description') }}">
                                <x-invalid-feedback name="description" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="amount">Amount</label>
                                <input type="number" name="amount" class="form-control {{ is_invalid($errors, 'amount') }}" value="{{ old('amount') }}">
                                <x-invalid-feedback name="amount" />
                            </div>
                            <div class="form-group mb-3">
                                <label for="category_id">Category</label>
                                <select name="category_id" id="category_id" class="form-select {{ is_invalid($errors, 'category_id') }}">
                                    <option value=""></option>
                                    @foreach($categories as $id => $name)
                                        <option value="{{ $id }}" @selected(old('category_id') == $id)>{{ $name }}</option>
                                    @endforeach
                                </select>
                                <x-invalid-feedback name="category_id" />
                            </div>
                            <button class="btn btn-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
