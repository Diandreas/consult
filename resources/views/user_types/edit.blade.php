@extends('layouts.app')

@section('content')
    <h1>Edit User Type</h1>
    <form action="{{ route('user_types.update', $userType->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $userType->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
