@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="mb-4">Consultation Answer Details</h1>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Answer</h2>
                <p class="card-text"><strong>Description:</strong> {{ $consultationAnswer->description }}</p>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-body">
                <h2 class="card-title">Related Consultation Request</h2>
                <p class="card-text"><strong>Description:</strong> {{ $consultationAnswer->consultationRequest->description }}</p>
                <p class="card-text"><strong>Status:</strong> {{ $consultationAnswer->consultationRequest->status }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('consultation_answers.index') }}" class="btn btn-secondary">Back to List</a>

            @if($consultationAnswer->consultationRequest->status !== 'accepted' && $consultationAnswer->consultationRequest->status !== 'rejected')
                <div>
                    <form action="{{ route('consultation_requests.accept', $consultationAnswer->consultationRequest->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-success">Accept Request</button>
                    </form>
                    <form action="{{ route('consultation_requests.reject', $consultationAnswer->consultationRequest->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" class="btn btn-danger">Reject Request</button>
                    </form>
                </div>
            @endif
        </div>
    </div>
@endsection
