<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('documents.update', $document) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Référence -->
                            <div>
                                <label for="reference" class="block text-sm font-medium text-gray-700">{{ __('Référence') }}</label>
                                <input type="text" name="reference" id="reference" value="{{ old('reference', $document->reference) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('reference')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Titre -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Titre') }}</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $document->title) }}" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Intitulé/analyse -->
                            <div>
                                <label for="title_analysis" class="block text-sm font-medium text-gray-700">{{ __('Intitulé/analyse') }}</label>
                                <input type="text" name="title_analysis" id="title_analysis" value="{{ old('title_analysis', $document->title_analysis) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('title_analysis')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                                <input type="date" name="date" id="date" value="{{ old('date', $document->date) }}" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Typologie documentaire -->
                            <div>
                                <label for="document_typology" class="block text-sm font-medium text-gray-700">{{ __('Typologie documentaire') }}</label>
                                <input type="text" name="document_typology" id="document_typology" value="{{ old('document_typology', $document->document_typology) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('document_typology')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Importance matérielle -->
                            <div>
                                <label for="material_importance" class="block text-sm font-medium text-gray-700">{{ __('Importance matérielle') }}</label>
                                <input type="text" name="material_importance" id="material_importance" value="{{ old('material_importance', $document->material_importance) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('material_importance')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Action administrative -->
                            <div>
                                <label for="administrative_action" class="block text-sm font-medium text-gray-700">{{ __('Action administrative') }}</label>
                                <input type="text" name="administrative_action" id="administrative_action" value="{{ old('administrative_action', $document->administrative_action) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('administrative_action')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Thématique -->
                            <div>
                                <label for="theme" class="block text-sm font-medium text-gray-700">{{ __('Thématique') }}</label>
                                <input type="text" name="theme" id="theme" value="{{ old('theme', $document->theme) }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('theme')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fichier -->
                            <div class="col-span-2">
                                <label for="file" class="block text-sm font-medium text-gray-700">{{ __('Fichier') }}</label>
                                @if($document->file_path)
                                    <div class="mb-2">
                                        <span class="text-sm text-gray-500">{{ __('Fichier actuel:') }} </span>
                                        <a href="{{ Storage::url($document->file_path) }}" target="_blank" class="text-blue-500 hover:underline">
                                            {{ basename($document->file_path) }}
                                        </a>
                                    </div>
                                @endif
                                <input type="file" name="file" id="file"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="text-gray-500 text-xs mt-1">{{ __('Format: PDF, Word, Excel, etc. (max. 10MB)') }}</p>
                                @error('file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Présentation du contenu -->
                            <div class="col-span-2">
                                <label for="content_presentation" class="block text-sm font-medium text-gray-700">{{ __('Présentation du contenu') }}</label>
                                <textarea name="content_presentation" id="content_presentation" rows="4"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('content_presentation', $document->content_presentation) }}</textarea>
                                @error('content_presentation')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <!-- Champ caché pour conserver le type de document -->
                            <input type="hidden" name="document_type_id" value="{{ $document->document_type_id }}">
                            
                            <!-- Champ caché pour conserver la description -->
                            <input type="hidden" name="description" value="{{ $document->description }}">
                        </div>

                        <div class="flex justify-end mt-6 space-x-3">
                            <a href="{{ route('documents.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                                {{ __('Annuler') }}
                            </a>
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                {{ __('Enregistrer') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 