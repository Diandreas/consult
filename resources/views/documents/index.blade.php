<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Bibliothèque de documents') }}
            </h2>
            <div class="flex space-x-4">
                <a href="{{ route('documents.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Ajouter un document') }}
                </a>
                <a href="{{ route('documents.export') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Exporter CSV') }}
                </a>
                <a href="{{ route('documents.export-excel') }}" class="bg-green-600 hover:bg-green-800 text-white font-bold py-2 px-4 rounded">
                    {{ __('Exporter Excel') }}
                </a>
                <a href="{{ route('documents.import-form') }}" class="bg-orange-500 hover:bg-orange-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Importer') }}
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(count($documents) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Référence') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Titre') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Date') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Thématique') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Fichier') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documents as $document)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $document->reference ?? $document->title }}</td>
                                            <td class="py-2 px-4 border-b">{{ $document->title_analysis ?? $document->title }}</td>
                                            <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($document->date)->format('d/m/Y') }}</td>
                                            <td class="py-2 px-4 border-b">{{ $document->theme ?? '-' }}</td>
                                            <td class="py-2 px-4 border-b">
                                                @if($document->file_path)
                                                    <a href="{{ route('documents.download', $document) }}" class="text-blue-500 hover:underline">
                                                        <i class="fas fa-download"></i> {{ __('Télécharger') }}
                                                    </a>
                                                @else
                                                    <span class="text-gray-400">{{ __('Aucun fichier') }}</span>
                                                @endif
                                            </td>
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('documents.show', $document) }}" class="text-blue-500 hover:text-blue-700">
                                                        <i class="fas fa-eye"></i> {{ __('Voir') }}
                                                    </a>
                                                    <a href="{{ route('documents.edit', $document) }}" class="text-yellow-500 hover:text-yellow-700">
                                                        <i class="fas fa-edit"></i> {{ __('Éditer') }}
                                                    </a>
                                                    <form action="{{ route('documents.destroy', $document) }}" method="POST" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce document ?') }}');" class="inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-500 hover:text-red-700">
                                                            <i class="fas fa-trash"></i> {{ __('Supprimer') }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="mt-4">
                            {{ $documents->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">{{ __('Aucun document trouvé.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 