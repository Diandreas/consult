@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h1 class="mb-3">{{ __('Types de Documents') }}</h1>
        </div>
        <div class="col-md-6 text-md-end">
            <a href="{{ route('document-types.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-1"></i> {{ __('Créer un Type de Document') }}
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-white">
            <form action="{{ route('document-types.index') }}" method="GET" class="row g-3">
                <div class="col-md-8">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control" placeholder="{{ __('Rechercher par nom...') }}" value="{{ request('search') }}">
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="fas fa-search"></i> {{ __('Rechercher') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            
            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>{{ __('ID') }}</th>
                            <th>{{ __('Nom') }}</th>
                            <th>{{ __('Description') }}</th>
                            <th>{{ __('Nombre de Documents') }}</th>
                            <th class="text-end">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($documentTypes as $type)
                            <tr>
                                <td>{{ $type->id }}</td>
                                <td>{{ $type->name }}</td>
                                <td>{{ Str::limit($type->description, 50) }}</td>
                                <td>{{ $type->documents_count ?? 0 }}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('document-types.show', $type) }}" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('document-types.edit', $type) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('document-types.destroy', $type) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce type de document ?') }}')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4">
                                    <p class="text-muted mb-0">{{ __('Aucun type de document trouvé.') }}</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $documentTypes->links() }}
            </div>
        </div>
    </div>
</div>
@endsection 