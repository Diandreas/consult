@extends('layouts.app')

@section('content')
    <h1>Edit Priority</h1>
    <form action="{{ route('priorities.update', $priority->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" value="{{ $priority->name }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
