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
                @foreach($items as $author)
                <tr>
                    <td>{{ $author->id }}</td>
                    <td>{{ $author->name }}</td>
                    <td class="text-end">
                        <div class="d-flex justify-content-end align-items-center gap-2">
                            <a href="/authors/update/{{ $author->id }}" class="btn btn-outline-primary btn-sm">Edit</a>
                            <form action="/authors/delete/{{ $author->id }}" method="post" class="deletionform d-inline">
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

    <a href="/authors/create" class="btn btn-primary">Add new</a>
@endsection
