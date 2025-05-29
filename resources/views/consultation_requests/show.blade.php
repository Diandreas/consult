@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('Consultation Request Details') }}</h1>
        <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-4">
            <h2 class="text-xl font-bold mb-2">{{ __('Status') }}: {{ __($consultationRequest->status) }}</h2>
            <p class="mb-2">{{ __('Priority') }}: {{ $consultationRequest->priority->name }}</p>
            <p class="mb-2">{!! $consultationRequest->description !!}</p>
            <p class="mb-2">{{ __('Date Start') }}: {{ $consultationRequest->date_start }}</p>
            <p class="mb-2">{{ __('Date End') }}: {{ $consultationRequest->date_end }}</p>
            <a href="{{ route('consultation_requests.showDocument', $consultationRequest) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Download Document') }}</a>

            @if($consultationRequest->document)
            <div class="mt-4 p-4 bg-blue-50 rounded-lg">
                <h3 class="text-lg font-semibold text-blue-700">{{ __('Document de la bibliothèque associé') }}</h3>
                <p class="mb-1"><strong>{{ __('Référence') }}:</strong> {{ $consultationRequest->document->title }}</p>
                <p class="mb-1"><strong>{{ __('Type') }}:</strong> {{ $consultationRequest->document->documentType->name }}</p>
                <p class="mb-1"><strong>{{ __('Date') }}:</strong> {{ \Carbon\Carbon::parse($consultationRequest->document->date)->format('d/m/Y') }}</p>
                <p class="mb-3"><strong>{{ __('Description') }}:</strong> {{ $consultationRequest->document->description }}</p>
                
                @if($consultationRequest->document->file_path)
                <a href="{{ route('documents.download', $consultationRequest->document) }}" class="inline-block bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">
                    <i class="fas fa-download"></i> {{ __('Télécharger le document') }}
                </a>
                @endif
            </div>
            @endif

            <div class="flex justify-between mt-4">
                @if(auth()->user()->user_types_id == 1)
                    <a href="{{ route('consultation_requests.edit', $consultationRequest->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">{{ __('Edit') }}</a>
                    <form action="{{ route('consultation_requests.destroy', $consultationRequest->id) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{ __('Delete') }}</button>
                    </form>
                @endif
            </div>
        </div>

        @if($consultationRequest->status !== 'finished' && $consultationRequest->status !== 'rejected')
            <div class="flex justify-end space-x-2 mb-4">
                <form action="{{ route('consultation_requests.sendToCommittee', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">{{ __('Send to Committee') }}</button>
                </form>
                <form action="{{ route('consultation_requests.finish', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">{{ __('Finish') }}</button>
                </form>
                <form action="{{ route('consultation_requests.reject', $consultationRequest->id) }}" method="POST" class="inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">{{ __('Reject') }}</button>
                </form>
            </div>
        @endif

        @if(auth()->user()->user_types_id == 1 || auth()->user()->user_types_id == 2)
            <div class="flex justify-end mb-4">
                <button type="button" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded" data-toggle="modal" data-target="#replyModal">
                    {{ __('Reply') }}
                </button>
                <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded ml-2" data-toggle="modal" data-target="#sendFileModal">
                    {{ __('Send File') }}
                </button>
            </div>
        @endif

        <h2 class="text-xl font-bold mb-2">{{ __('Consultation Answers') }}</h2>

        @forelse ($consultationRequest->consultationAnswers as $answer)
            <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-2">
                <p>{!! $answer->description !!}</p>
                <p class="text-sm text-gray-600">{{ __('By') }}: <b>{{ $answer->user->name ?? 'ADMIN' }}</b> | {{ __('at') }}: {{ $answer->created_at }}</p>
                <div class="flex justify-end space-x-2 mt-2">
                    @if(auth()->user()->user_types_id == 1)
                        <button type="button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded" data-toggle="modal" data-target="#editModal{{ $answer->id }}">{{ __('Edit') }}</button>
                        <form action="{{ route('consultation_answers.destroy', $answer->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">{{ __('Delete') }}</button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Edit Modal -->
            <div class="modal fade" id="editModal{{ $answer->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel{{ $answer->id }}" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editModalLabel{{ $answer->id }}">{{ __('Edit Answer') }}</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('consultation_answers.update', $answer->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="mb-4">
                                    <label for="description{{ $answer->id }}" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}:</label>
                                    <textarea name="description" id="description{{ $answer->id }}" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Enter description') }}">{{ $answer->description }}</textarea>
                                    @error('description')
                                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div class="flex items-center justify-between">
                                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        {{ __('Update') }}
                                    </button>
                                    <button type="button" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-dismiss="modal">
                                        {{ __('Cancel') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <p>{{ __('No answers yet.') }}</p>
        @endforelse

        <h2 class="text-xl font-bold mb-2">{{ __('Documents') }}</h2>

        @forelse ($consultationRequest->userFiles as $userFile)
            <div class="bg-white rounded shadow p-4 border-b border-indigo-800 mb-2">
                <p>{{ $userFile->file_name }}</p>
                <p class="text-sm text-gray-600">{{ __('By') }}: <b>{{ $userFile->creator->name ?? 'ADMIN' }}</b> | {{ __('at') }}: {{ $userFile->created_at }}</p>
                <div class="flex justify-end space-x-2 mt-2">
                    <a href="{{ route('consultation_requests.files.show', [$consultationRequest->id, $userFile->id]) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">{{ __('Show') }}</a>
                    <a href="{{ route('user_files.download', $userFile->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 rounded">{{ __('Download') }}</a>
                    @if(auth()->user()->user_types_id == 1)
                        <form action="{{ route('user_files.destroy', $userFile->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">{{ __('Delete') }}</button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <p>{{ __('No documents.') }}</p>
        @endforelse

    </div>

    <!-- Reply Modal -->
    <div class="modal fade" id="replyModal" tabindex="-1" role="dialog" aria-labelledby="replyModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="replyModalLabel">{{ __('Reply to Consultation Request') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('consultation_answers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="consultation_request_id" value="{{ $consultationRequest->id }}">
                        <div class="mb-4">
                            <label for="description" class="block text-gray-700 text-sm font-bold mb-2">{{ __('Description') }}:</label>
                            <textarea name="description" id="description" rows="4" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="{{ __('Enter description') }}">{{ old('description') }}</textarea>
                            @error('description')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Create') }}
                            </button>
                            <button type="button" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Send File Modal -->
    <div class="modal fade" id="sendFileModal" tabindex="-1" role="dialog" aria-labelledby="sendFileModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="sendFileModalLabel">{{ __('Send File to') }} {{ $consultationRequest->user->name }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user_files.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $consultationRequest->user->id }}">
                        <div class="mb-4">
                            <label for="file" class="block text-gray-700 text-sm font-bold mb-2">{{ __('File') }}:</label>
                            <input type="file" name="file" id="file" class="form-control-file">
                            @error('file')
                            <p class="text-red-500 text-xs italic">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                {{ __('Send') }}
                            </button>
                            <button type="button" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" data-dismiss="modal">
                                {{ __('Cancel') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
