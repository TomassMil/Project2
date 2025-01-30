@extends('layout')

@section('content')

<h1>{{ $title }}</h1>

@if (count($items) > 0)
    <table class="table table-sm table-hover table-striped">
        <thead class="thead-light">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Author</th>
                <th>Year</th>
                <th>Price</th>
                <th>Published</th>
                <th class="text-end">Actions</th> <!-- Align buttons to the right -->
            </tr>
        </thead>
        <tbody>
            @foreach($items as $book)
            <tr>
                <td>{{ $book->id }}</td>
                <td>{{ $book->name }}</td>
                <td>{{ $book->category->name}}</td>
                <td>{{ $book->author->name }}</td>
                <td>{{ $book->year }}</td>
                <td>&euro; {{ number_format($book->price, 2, '.') }}</td>
                <td>{!! $book->display ? '&#x2714;' : '&#x274C;' !!}</td>
                <td class="text-end">
                    <div class="d-flex justify-content-end align-items-center gap-2">
                        <a href="/books/update/{{ $book->id }}" class="btn btn-outline-primary btn-sm">Edit</a>
                        <form method="post" action="/books/delete/{{ $book->id }}" class="d-inline deletion-form">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p>No entries found in database</p>
@endif

<a href="/books/create" class="btn btn-primary">Add new book</a>

@endsection
