@extends('layouts.app')

@section('content')
    <h1>Edit Consultation Answer</h1>
    <form action="{{ route('consultation_answers.update', $consultationAnswer->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" class="form-control" rows="3">{{ $consultationAnswer->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="consultation_request_id">Consultation Request</label>
            <select name="consultation_request_id" class="form-control">
                @foreach($consultationRequests as $consultationRequest)
                    <option value="{{ $consultationRequest->id }}" {{ $consultationAnswer->consultation_request_id == $consultationRequest->id ? 'selected' : '' }}>{{ $consultationRequest->description }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
@endsection
