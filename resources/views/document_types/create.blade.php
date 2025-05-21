@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Créer un Type de Document') }}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('document-types.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">{{ __('Nom') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="4">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('document-types.index') }}" class="btn btn-secondary">{{ __('Annuler') }}</a>
                            <button type="submit" class="btn btn-primary">{{ __('Enregistrer') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 