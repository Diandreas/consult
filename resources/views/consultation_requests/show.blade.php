<!-- resources/views/consultation_requests/show.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">Consultation Request Details</h1>
        <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-4">
            <h2 class="text-xl font-bold mb-2">Status: {{ $consultationRequest->status }}</h2>
            <p class="mb-2">Priority: {{ $consultationRequest->priority->name }}</p>
            <p class="mb-2">Category: {{ $consultationRequest->category->name }}</p>
            <p class="mb-2">{!! $consultationRequest->description !!}</p>
            <p class="mb-2">Date Start: {{ $consultationRequest->date_start }}</p>
            <p class="mb-2">Date End: {{ $consultationRequest->date_end }}</p>
            <div class="flex justify-between mt-4">
                <a href="{{ route('consultation_requests.edit', $consultationRequest->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                <form action="{{ route('consultation_requests.destroy', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
                </form>
            </div>
        </div>

        @if($consultationRequest->status !== 'accepted' && $consultationRequest->status !== 'rejected')
            <div class="flex justify-end space-x-2 mb-4">
                <form action="{{ route('consultation_requests.accept', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Accept</button>
                </form>
                <form action="{{ route('consultation_requests.reject', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Reject</button>
                </form>
            </div>
        @endif
        <div class="flex justify-end mb-4">
            <a href="{{ route('consultation-answers.create', $consultationRequest->id) }}"
               class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Reply
            </a>
        </div>

        <h2 class="text-xl font-bold mb-2">Consultation Answers</h2>
        @forelse ($consultationRequest->consultationAnswers as $answer)
            <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-2">
                <p>{!! $answer->description !!}</p>
                <p class="text-sm text-gray-600">Created at: {{ $answer->created_at }}</p>
            </div>
        @empty
            <p>No answers yet.</p>
        @endforelse
    </div>
@endsection
