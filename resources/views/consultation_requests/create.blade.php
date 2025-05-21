@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('Create Consultation Request') }}</h1>
        <form action="{{ route('consultation_requests.store') }}" method="POST">
            @csrf
            <div class="form-group mb-4">
                <label for="description" class="block text-gray-700">{{ __('Description') }}</label>
                <textarea name="description" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="description"></textarea>
            </div>
            <div class="form-group mb-4">
                <label for="date_start" class="block text-gray-700">{{ __('Date Start') }}</label>
                <input type="datetime-local" name="date_start" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_start">
            </div>
            <div class="form-group mb-4">
                <label for="date_end" class="block text-gray-700">{{ __('Date End') }}</label>
                <input type="datetime-local" name="date_end" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_end">
            </div>
            <div class="form-group mb-4">
                <input type="hidden" name="status" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="status" value="pending">
            </div>
            <div class="form-group mb-4">
                <label for="priority_id" class="block text-gray-700">{{ __('Priority') }}</label>
                <select name="priority_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="priority_id">
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="document_id" class="block text-gray-700">{{ __('Document de la bibliothèque') }}</label>
                <select name="document_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="document_id">
                    <option value="">{{ __('Sélectionner un document (optionnel)') }}</option>
                    @foreach($documents as $document)
                        <option value="{{ $document->id }}">{{ $document->title }} ({{ $document->documentType->name }})</option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-1">{{ __('Si le document que vous cherchez est déjà dans notre bibliothèque, vous pouvez le spécifier ici.') }}</p>
            </div>
            {{--            <div class="form-group mb-4">--}}
            {{--                <label for="category_id" class="block text-gray-700">{{ __('Category') }}</label>--}}
            {{--                <select name="category_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="category_id">--}}
            {{--                    @foreach($categories as $category)--}}
            {{--                        <option value="{{ $category->id }}">{{ $category->name }}</option>--}}
            {{--                    @endforeach--}}
            {{--                </select>--}}
            {{--            </div>--}}
            <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded">{{ __('Submit') }}</button>
        </form>
    </div>
@endsection
