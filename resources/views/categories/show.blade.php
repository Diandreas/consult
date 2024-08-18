@extends('layouts.app')

@section('content')
    <h1>Category Details</h1>
    <p><strong>Name:</strong> {{ $category->name }}</p>
    <a href="{{ route('categories.index') }}" class="btn btn-primary">Back to List</a>
@endsection
