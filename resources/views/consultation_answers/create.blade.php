@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Create Consultation Answer</h1>

        <div class="card mb-4">
            <div class="card-header">
                <h2 class="h5 mb-0">Associated Consultation Request</h2>
            </div>
            <div class="card-body">
                <p><strong>Request ID:</strong> {{ $consultationRequest->id }}</p>
                <p><strong>Request Summary:</strong> {{ Str::limit($consultationRequest->description, 100) }}</p>
            </div>
        </div>

        <form action="{{ route('consultation-answers.store') }}" method="POST">
            @csrf
            <input type="hidden" name="consultation_request_id" value="{{ $consultationRequest->id }}">

            <div class="form-group mb-4">
                <label for="description" class="form-label">Answer Description</label>
                <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="6" required>{{ old('description') }}</textarea>
                @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Created By</label>
                        <input type="text" class="form-control" value="{{ Auth::user()->name }}" readonly>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Created At</label>
                        <input type="text" class="form-control" value="{{ now()->format('Y-m-d H:i:s') }}" readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Submit Answer</button>
        </form>
    </div>
@endsection
