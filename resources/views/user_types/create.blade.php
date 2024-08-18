@extends('layouts.app')

@section('content')
    <h1>Create User Type</h1>
    <form action="{{ route('user_types.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Create</button>
    </form>
@endsection
