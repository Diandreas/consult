@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Importer des Documents') }}</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <p>{{ __('Veuillez télécharger un fichier CSV ou Excel contenant les données des documents.') }}</p>
                        <p>{{ __('Après le téléchargement, vous pourrez associer les colonnes de votre fichier aux champs appropriés.') }}</p>
                        <p><strong>{{ __('Note') }}:</strong> {{ __('Pour les fichiers Excel, assurez-vous que les cellules contiennent des valeurs simples et non des formules complexes.') }}</p>
                    </div>

                    <form action="{{ route('documents.process-import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-3">
                            <label for="file" class="form-label">{{ __('Fichier CSV/Excel') }}</label>
                            <input type="file" name="file" id="file" class="form-control @error('file') is-invalid @enderror" required>
                            @error('file')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            <div class="form-text">
                                {{ __('Formats acceptés: CSV (.csv), Excel (.xlsx, .xls)') }}
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload mr-1"></i> {{ __('Télécharger et Continuer') }}
                            </button>
                            <a href="{{ route('documents.index') }}" class="btn btn-secondary ml-2">
                                {{ __('Annuler') }}
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 