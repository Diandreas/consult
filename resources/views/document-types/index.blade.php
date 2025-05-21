<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Types de documents') }}
            </h2>
            <a href="{{ route('document-types.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                {{ __('Ajouter un type') }}
            </a>
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

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            <span class="block sm:inline">{{ session('error') }}</span>
                        </div>
                    @endif

                    @if(count($documentTypes) > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full bg-white">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Nom') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Description') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Nombre de documents') }}</th>
                                        <th class="py-2 px-4 border-b text-left">{{ __('Actions') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentTypes as $type)
                                        <tr>
                                            <td class="py-2 px-4 border-b">{{ $type->name }}</td>
                                            <td class="py-2 px-4 border-b">{{ $type->description }}</td>
                                            <td class="py-2 px-4 border-b">{{ $type->documents_count }}</td>
                                            <td class="py-2 px-4 border-b">
                                                <div class="flex space-x-2">
                                                    <a href="{{ route('document-types.show', $type) }}" class="text-blue-500 hover:text-blue-700">
                                                        <i class="fas fa-eye"></i> {{ __('Voir') }}
                                                    </a>
                                                    <a href="{{ route('document-types.edit', $type) }}" class="text-yellow-500 hover:text-yellow-700">
                                                        <i class="fas fa-edit"></i> {{ __('Éditer') }}
                                                    </a>
                                                    <form action="{{ route('document-types.destroy', $type) }}" method="POST" onsubmit="return confirm('{{ __('Êtes-vous sûr de vouloir supprimer ce type de document ?') }}');" class="inline">
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
                            {{ $documentTypes->links() }}
                        </div>
                    @else
                        <div class="text-center py-4">
                            <p class="text-gray-500">{{ __('Aucun type de document trouvé.') }}</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 