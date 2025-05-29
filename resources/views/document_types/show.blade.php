@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col-md-8">
            <h1 class="mb-0">{{ $documentType->name }}</h1>
        </div>
        <div class="col-md-4 text-md-end">
            <a href="{{ route('document-types.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> {{ __('Retour à la liste') }}
            </a>
            <a href="{{ route('document-types.edit', $documentType) }}" class="btn btn-warning">
                <i class="fas fa-edit me-1"></i> {{ __('Modifier') }}
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Détails du Type de Document') }}</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th class="w-25">{{ __('ID') }}</th>
                            <td>{{ $documentType->id }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Nom') }}</th>
                            <td>{{ $documentType->name }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Description') }}</th>
                            <td>{{ $documentType->description ?: __('Non spécifié') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Créé le') }}</th>
                            <td>{{ $documentType->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>{{ __('Dernière modification') }}</th>
                            <td>{{ $documentType->updated_at->format('d/m/Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-light">
                    <h3 class="mb-0">{{ __('Documents associés') }}</h3>
                </div>
                <div class="card-body">
                    @if($documentType->documents && $documentType->documents->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>{{ __('ID') }}</th>
                                        <th>{{ __('Référence') }}</th>
                                        <th>{{ __('Date') }}</th>
                                        <th>{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentType->documents as $document)
                                        <tr>
                                            <td>{{ $document->id }}</td>
                                            <td>{{ $document->title }}</td>
                                            <td>{{ $document->date }}</td>
                                            <td>
                                                <a href="{{ route('documents.show', $document) }}" class="btn btn-sm btn-info">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted mb-0">{{ __('Aucun document n\'est associé à ce type.') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 