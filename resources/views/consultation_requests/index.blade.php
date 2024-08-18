@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <header class="mb-8">
            <h1 class="text-4xl font-bold text-indigo-800 mb-2">Consultation Requests</h1>
            <p class="text-lg text-gray-600">Manage and view all consultation requests</p>
        </header>

        <div class="bg-white shadow-lg rounded-lg p-6 mb-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <form action="{{ route('consultation_requests.index') }}" method="GET" class="flex w-full md:w-auto">
                    <input type="text" name="search" placeholder="Search" value="{{ request('search') }}" class="flex-grow md:flex-grow-0 border border-gray-300 rounded-l px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <select name="search_type" class="border-t border-b border-gray-300 px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="all" {{ request('search_type') == 'all' ? 'selected' : '' }}>All</option>
                        <option value="priority" {{ request('search_type') == 'priority' ? 'selected' : '' }}>Priority</option>
                        <option value="status" {{ request('search_type') == 'status' ? 'selected' : '' }}>Status</option>
                        <option value="name" {{ request('search_type') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="description" {{ request('search_type') == 'description' ? 'selected' : '' }}>Description</option>
                    </select>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-r transition duration-150 ease-in-out flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                        Search
                    </button>
                </form>
                <a href="{{ route('consultation_requests.create') }}" class="bg-green-500 hover:bg-green-600 text-white font-semibold px-6 py-2 rounded transition duration-150 ease-in-out flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Create New Request
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($consultationRequests as $request)
                <article class="bg-white rounded-lg shadow-md overflow-hidden flex flex-col transform hover:scale-105 transition-transform duration-200">
                    <header class="bg-indigo-600 text-white py-3 px-4">
                        <h2 class="text-xl font-semibold">{{ $request->status }}</h2>
                    </header>
                    <div class="p-4 flex-grow">
                        <p class="text-gray-600 mb-2"><span class="font-semibold text-indigo-600">Priority:</span> {{ $request->priority->name }}</p>
                        <p class="text-gray-600 mb-2"><span class="font-semibold text-indigo-600">Category:</span> {{ $request->category->name }}</p>
                        <div class="text-gray-800 mb-4 line-clamp-3">{!! $request->description !!}</div>
                    </div>
                    <footer class="bg-gray-50 px-4 py-3 mt-auto">
                        <div class="flex justify-between items-center">
                            <a href="{{ route('consultation_requests.show', $request->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">View</a>
                            <a href="{{ route('consultation_requests.edit', $request->id) }}" class="text-indigo-600 hover:text-indigo-800 font-medium">Edit</a>
                            <form action="{{ route('consultation_requests.destroy', $request->id) }}" method="POST" class="inline">
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
