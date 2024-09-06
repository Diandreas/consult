@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('Edit Consultation Request') }}</h1>
        <form action="{{ route('consultation_requests.update', $consultationRequest->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group mb-4">
                <label for="description" class="block text-gray-700">{{ __('Description') }}</label>
                <textarea name="description" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="description">{{ $consultationRequest->description }}</textarea>
            </div>
            <div class="form-group mb-4">
                <label for="date_start" class="block text-gray-700">{{ __('Date Start') }}</label>
                <input type="datetime-local" name="date_start" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_start" value="{{ $consultationRequest->date_start }}">
            </div>
            <div class="form-group mb-4">
                <label for="date_end" class="block text-gray-700">{{ __('Date End') }}</label>
                <input type="datetime-local" name="date_end" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_end" value="{{ $consultationRequest->date_end }}">
            </div>
            <div class="form-group mb-4">
                <label for="status" class="block text-gray-700">{{ __('Status') }}</label>
                <input type="text" name="status" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="status" value="{{ $consultationRequest->status }}">
            </div>
            <div class="form-group mb-4">
                <label for="priority_id" class="block text-gray-700">{{ __('Priority') }}</label>
                <select name="priority_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="priority_id">
                    @foreach($priorities as $priority)
                        <option value="{{ $priority->id }}" {{ $consultationRequest->priority_id == $priority->id ? 'selected' : '' }}>{{ $priority->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group mb-4">
                <label for="category_id" class="block text-gray-700">{{ __('Category') }}</label>
                <select name="category_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $consultationRequest->category_id == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-indigo-700 text-white px-4 py-2 rounded">{{ __('Update') }}</button>
        </form>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/4.16.0/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace('description');
    </script>
@endsection
