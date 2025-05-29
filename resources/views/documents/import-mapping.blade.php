@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Mappage des Colonnes') }}</h3>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        {{ __('Veuillez sélectionner les colonnes correspondantes à chaque champ du document.') }}
                    </div>

                    <h4>{{ __('Aperçu des données') }}</h4>
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    @foreach($header as $index => $column)
                                    <th>{{ $column }} ({{ $index }})</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    @foreach($sampleRow as $value)
                                    <td>{{ $value }}</td>
                                    @endforeach
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <form action="{{ route('documents.import-documents') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="reference_column">{{ __('Colonne de la Référence') }}</label>
                                    <select name="reference_column" id="reference_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_column">{{ __('Colonne du Titre') }} <span class="text-danger">*</span></label>
                                    <select name="title_column" id="title_column" class="form-control" required>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="title_analysis_column">{{ __('Colonne de l\'Intitulé/analyse') }}</label>
                                    <select name="title_analysis_column" id="title_analysis_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="date_column">{{ __('Colonne de la Date') }} <span class="text-danger">*</span></label>
                                    <select name="date_column" id="date_column" class="form-control" required>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="document_typology_column">{{ __('Colonne de la Typologie documentaire') }}</label>
                                    <select name="document_typology_column" id="document_typology_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="content_presentation_column">{{ __('Colonne de la Présentation du contenu') }}</label>
                                    <select name="content_presentation_column" id="content_presentation_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="material_importance_column">{{ __('Colonne de l\'Importance matérielle') }}</label>
                                    <select name="material_importance_column" id="material_importance_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="administrative_action_column">{{ __('Colonne de l\'Action administrative') }}</label>
                                    <select name="administrative_action_column" id="administrative_action_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="theme_column">{{ __('Colonne de la Thématique') }}</label>
                                    <select name="theme_column" id="theme_column" class="form-control">
                                        <option value="">{{ __('-- Non applicable --') }}</option>
                                        @foreach($header as $index => $column)
                                        <option value="{{ $index }}">{{ $column }} ({{ $index }})</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Champs cachés pour les valeurs par défaut -->
                            <input type="hidden" name="document_type_id" value="1">
                            <input type="hidden" name="description_column" value="0">
                        </div>

                        <div class="form-group mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-file-import mr-1"></i> {{ __('Importer les Documents') }}
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