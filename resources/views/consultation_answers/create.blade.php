@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-indigo-800 mb-2">Create New Consultation Answer</h1>
            <p class="text-lg text-gray-600">Fill out the form below to create a new consultation answer</p>
        </header>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
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

                <div class="mb-4">
                    <label for="consultation_request_id" class="block text-gray-700 text-sm font-bold mb-2">Consultation Request:</label>
                    <select name="consultation_request_id" id="consultation_request_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        @foreach($consultationRequests as $request)
                            <option value="{{ $request->id }}" {{ $request->id == $consultationRequest->id ? 'selected' : '' }}>
                                {{ $request->description }}
                            </option>
                        @endforeach
                    </select>
                    @error('consultation_request_id')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between">
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Create
                    </button>
                    <a href="{{ route('consultation_answers.index') }}" class="text-gray-600 hover:text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
