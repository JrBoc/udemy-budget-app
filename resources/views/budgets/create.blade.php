@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Create Budget
                    </div>
                    <div class="card-body">
                        <x-form action="{{ route('budgets.store') }}" method="post">
                            @include('budgets._form')
                        </x-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
