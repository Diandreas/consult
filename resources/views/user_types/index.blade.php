@extends('layouts.app')

@section('content')
    <h1>User Types</h1>
    <a href="{{ route('user_types.create') }}" class="btn btn-primary">Create New User Type</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($userTypes as $userType)
            <tr>
                <td>{{ $userType->id }}</td>
                <td>{{ $userType->name }}</td>
                <td>
                    <a href="{{ route('user_types.show', $userType->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('user_types.edit', $userType->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('user_types.destroy', $userType->id) }}" method="POST" style="display:inline;">
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
