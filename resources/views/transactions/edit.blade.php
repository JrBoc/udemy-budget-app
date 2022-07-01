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
                        <x-form action="{{ route('transactions.update', $transaction) }}" method="put">
                            @include('transactions._form')
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
