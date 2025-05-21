<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $document->title }}
            </h2>
            <div class="flex space-x-2">
                <a href="{{ route('documents.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    <i class="fas fa-arrow-left mr-1"></i> {{ __('Retour') }}
                </a>
                <a href="{{ route('documents.edit', $document) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-edit mr-1"></i> {{ __('Modifier') }}
                </a>
                @if($document->file_path)
                <a href="{{ route('documents.download', $document) }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    <i class="fas fa-download mr-1"></i> {{ __('Télécharger') }}
                </a>
                @endif
                <form action="{{ route('documents.destroy', $document) }}" method="POST" class="inline" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce document ?') }}');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                        <i class="fas fa-trash mr-1"></i> {{ __('Supprimer') }}
                    </button>
                </form>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Informations du document') }}</h3>
                            <div class="bg-gray-50 p-4 rounded-lg">
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500">{{ __('Type de document') }}</p>
                                    <p class="text-lg">{{ $document->documentType->name }}</p>
                                </div>
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500">{{ __('Date') }}</p>
                                    <p class="text-lg">{{ \Carbon\Carbon::parse($document->date)->format('d/m/Y') }}</p>
                                </div>
                                @if($document->material_condition)
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500">{{ __('État matériel') }}</p>
                                    <p class="text-lg">{{ $document->material_condition }}</p>
                                </div>
                                @endif
                                <div class="mb-4">
                                    <p class="text-sm font-medium text-gray-500">{{ __('Fichier') }}</p>
                                    @if($document->file_path)
                                        <a href="{{ route('documents.download', $document) }}" class="text-blue-500 hover:underline flex items-center">
                                            <i class="fas fa-file-download mr-1"></i>
                                            <span>{{ basename($document->file_path) }}</span>
                                        </a>
                                    @else
                                        <p class="text-gray-400">{{ __('Aucun fichier attaché') }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Description') }}</h3>
                            <div class="bg-gray-50 p-4 rounded-lg min-h-[200px]">
                                {!! $document->description !!}
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">{{ __('Métadonnées') }}</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Créé le') }}</p>
                                    <p>{{ $document->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">{{ __('Dernière modification') }}</p>
                                    <p>{{ $document->updated_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 