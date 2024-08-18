<!-- resources/views/consultation_requests/show.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Consultation Request Details</h1>
        <div class="bg-white rounded shadow p-4 border-b border-indigo-800">
            <h2 class="text-xl font-bold mb-2">{{ $consultationRequest->status }}</h2>
            <p class="mb-2">Priority: {{ $consultationRequest->priority->name }}</p>
            <p class="mb-2">Category: {{ $consultationRequest->category->name }}</p>
            <p class="mb-2">{!! $consultationRequest->description !!}</p>
            <p class="mb-2">Date Start: {{ $consultationRequest->date_start }}</p>
            <p class="mb-2">Date End: {{ $consultationRequest->date_end }}</p>
            <div class="flex justify-between">
                <a href="{{ route('consultation_requests.edit', $consultationRequest->id) }}" class="text-indigo-700 hover:underline">Edit</a>
                <form action="{{ route('consultation_requests.destroy', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                </form>
            </div>
        </div>
    </div>
@endsection
