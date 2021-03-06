@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Remove</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($categories as $category)
                                    <tr>
                                        <td>{{ $category->created_at->format('m/d/Y') }}</td>
                                        <td>
                                            <a href="{{ route('categories.edit', $category) }}">{{ $category->name }}</a>
                                        </td>
                                        <td>{{ $category->slug }}</td>
                                        <td>
                                            <x-form action="{{ route('categories.destroy', $category) }}" method="delete">
                                                <button class="btn btn-danger btn-sm" type="submit" onclick="return confirm('Are you sure?')">Remove</button>
                                            </x-form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            {{ $categories->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
