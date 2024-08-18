@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-indigo-800 mb-2">Consultation Answers</h1>
            <p class="text-lg text-gray-600">Manage and view all consultation answers</p>
        </header>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <a href="{{ route('consultation_answers.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded transition duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Answer
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($consultationAnswers as $consultationAnswer)
                <article class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col transform hover:scale-105 transition-transform duration-200">
                    <header class="bg-indigo-600 text-white py-3 px-4">
                        <h2 class="text-xl font-semibold">{{ $consultationAnswer->id }}</h2>
                    </header>
                    <div class="p-4 flex-grow">
                        <p class="text-gray-600 mb-2"><span class="font-semibold text-indigo-600">Description:</span> {{ $consultationAnswer->description }}</p>
                        <p class="text-gray-600 mb-2"><span class="font-semibold text-indigo-600">Consultation Request:</span> {{ $consultationAnswer->consultationRequest->description }}</p>
                    </div>
                    <footer class="bg-gray-50 px-4 py-3 mt-auto">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('consultation_answers.show', $consultationAnswer->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>
                            <a href="{{ route('consultation_answers.edit', $consultationAnswer->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                            <form action="{{ route('consultation_answers.destroy', $consultationAnswer->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                            </form>
                        </div>
                    </footer>
                </article>
            @endforeach
        </div>
    </div>
@endsection
