@extends('layouts.app')

@section('content')
    <h1>User Type Details</h1>
    <p><strong>Name:</strong> {{ $userType->name }}</p>
    <a href="{{ route('user_types.index') }}" class="btn btn-primary">Back to List</a>
@endsection
