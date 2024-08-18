@extends('layouts.app')

@section('content')
    <h1>Priority Details</h1>
    <p><strong>Name:</strong> {{ $priority->name }}</p>
    <a href="{{ route('priorities.index') }}" class="btn btn-primary">Back to List</a>
@endsection
