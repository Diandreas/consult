<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un document') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form action="{{ route('documents.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                            <!-- Titre -->
                            <div>
                                <label for="title" class="block text-sm font-medium text-gray-700">{{ __('Titre') }}</label>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('title')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Date -->
                            <div>
                                <label for="date" class="block text-sm font-medium text-gray-700">{{ __('Date') }}</label>
                                <input type="date" name="date" id="date" value="{{ old('date', date('Y-m-d')) }}" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('date')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Type de document -->
                            <div>
                                <label for="document_type_id" class="block text-sm font-medium text-gray-700">{{ __('Type de document') }}</label>
                                <select name="document_type_id" id="document_type_id" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    <option value="">{{ __('Sélectionnez un type') }}</option>
                                    @foreach($documentTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('document_type_id') == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('document_type_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- État matériel -->
                            <div>
                                <label for="material_condition" class="block text-sm font-medium text-gray-700">{{ __('État matériel') }}</label>
                                <input type="text" name="material_condition" id="material_condition" value="{{ old('material_condition') }}"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                @error('material_condition')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Fichier -->
                            <div class="col-span-2">
                                <label for="file" class="block text-sm font-medium text-gray-700">{{ __('Fichier') }}</label>
                                <input type="file" name="file" id="file"
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                <p class="text-gray-500 text-xs mt-1">{{ __('Format: PDF, Word, Excel, etc. (max. 10MB)') }}</p>
                                @error('file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Description -->
                            <div class="col-span-2">
                                <label for="description" class="block text-sm font-medium text-gray-700">{{ __('Description') }}</label>
                                <textarea name="description" id="description" rows="4" required
                                    class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
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