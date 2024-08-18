@extends('layouts.app')

@section('content')
    <h1>Consultation Answers</h1>
    <a href="{{ route('consultation_answers.create') }}" class="btn btn-primary">Create New Consultation Answer</a>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Description</th>
            <th>Consultation Request</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($consultationAnswers as $consultationAnswer)
            <tr>
                <td>{{ $consultationAnswer->id }}</td>
                <td>{{ $consultationAnswer->description }}</td>
                <td>{{ $consultationAnswer->consultationRequest->description }}</td>
                <td>
                    <a href="{{ route('consultation_answers.show', $consultationAnswer->id) }}" class="btn btn-info">Show</a>
                    <a href="{{ route('consultation_answers.edit', $consultationAnswer->id) }}" class="btn btn-warning">Edit</a>
                    <form action="{{ route('consultation_answers.destroy', $consultationAnswer->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
