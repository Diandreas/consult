@extends('layouts.app')

@section('content')
    <h1>Consultation Answer Details</h1>
    <p><strong>Description:</strong> {{ $consultationAnswer->description }}</p>
    <p><strong>Consultation Request:</strong> {{ $consultationAnswer->consultationRequest->description }}</p>
    <a href="{{ route('consultation_answers.index') }}" class="btn btn-primary">Back to List</a>
@endsection
