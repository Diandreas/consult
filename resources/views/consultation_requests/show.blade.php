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
            <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-toggle="modal" data-target="#replyModal">
                Reply
            </button>
        </div>

        <h2 class="text-xl font-bold mb-2">Consultation Answers</h2>
        @forelse ($consultationRequest->consultationAnswers as $answer)
            <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-2">
                <p>{!! $answer->description !!}</p>
                <p class="text-sm text-gray-600">Created at: {{ $answer->created_at }}</p>
                <div class="flex justify-end space-x-2 mt-2">
                    <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" data-toggle="modal" data-target="#editModal{{ $answer->id }}">Edit</button>
                    <form action="{{ route('consultation_answers.destroy', $answer->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                    </form>
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $answer->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $answer->id }}">Edit Answer</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('consultation_answers.update', $answer->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="description{{ $answer->id }}" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                                    <textarea name="description" id="description{{ $answer->id }}" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter description">{{ $answer->description }}</textarea>
                                    @error('description')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Update
                                    </button>
                                    <button type="button" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-dismiss="modal">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>No answers yet.</p>
        @endforelse
    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">Reply to Consultation Request</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('consultation_answers.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="consultation_request_id" value="{{ $consultationRequest->id }}">
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">Description:</label>
                            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Enter description">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                Create
                            </button>
                            <button type="button" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-dismiss="modal">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
