@extends('layout')

@section('content')
    <h1>{{ $title }}</h1>

    @if (count($items) > 0)
        <table class="table table-striped table-hover table-sm">
            <thead class="thead-light">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th class="text-end">Actions</th> <!-- Align buttons to the right -->
                </tr>
            </thead>
            <tbody>
                @foreach($items as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="/categories/update/{{ $category->id }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form action="/categories/delete/{{ $category->id }}" method="post" class="deletionform d-inline">
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

    <a href="/categories/create" class="btn btn-primary">Add new</a>
@endsection
