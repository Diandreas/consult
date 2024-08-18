@extends('layouts.app')

@section('content')
    <h1>Priorities</h1>
    <a href="{{ route('priorities.create') }}" class="btn btn-primary">Create New Priority</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($priorities as $priority)
            <tr>
                <td>{{ $priority->id }}</td>
                <td>{{ $priority->name }}</td>
                <td>
                    <a href="{{ route('priorities.show', $priority->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('priorities.edit', $priority->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('priorities.destroy', $priority->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
