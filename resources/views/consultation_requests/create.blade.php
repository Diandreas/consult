@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('Créer une demande de consultation') }}</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form id="consultationForm" action="{{ route('consultation_requests.store') }}" method="POST">
                @csrf
                
                <!-- Sélection de document -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Document de la bibliothèque') }}</label>
                    
                    <div class="flex items-start mb-4">
                        <div class="flex items-center h-5">
                            <input id="hasDocument" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <label for="hasDocument" class="ml-2 text-sm font-medium text-gray-700">
                            {{ __('Je souhaite consulter un document de la bibliothèque') }}
                        </label>
                    </div>
                    
                    <div id="documentSelection" class="hidden">
                        <div class="flex items-center mb-4">
                            <input type="hidden" name="document_id" id="selected_document_id">
                            <div id="selectedDocument" class="w-full p-4 bg-gray-50 rounded-lg border border-gray-200 mb-2 hidden">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 id="doc_title" class="font-medium"></h3>
                                        <p id="doc_reference" class="text-sm text-gray-500"></p>
                                        <p id="doc_date" class="text-sm text-gray-500"></p>
                                    </div>
                                    <button type="button" id="removeDocument" class="text-red-500 hover:text-red-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            
                            <button type="button" id="openDocumentModal" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md">
                                {{ __('Rechercher un document') }}
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Formulaire dynamique -->
                <div id="noDocumentForm">
                    <div class="form-group mb-4">
                        <label for="description" class="block text-gray-700 font-semibold mb-2">{{ __('Description de votre demande') }} <span class="text-red-500">*</span></label>
                        <textarea name="description" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="description" rows="4" required></textarea>
                        <p class="text-sm text-gray-500 mt-1">{{ __('Décrivez précisément les informations que vous recherchez.') }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div class="form-group">
                            <label for="date_start" class="block text-gray-700 font-semibold mb-2">{{ __('Date de début souhaitée') }}</label>
                            <input type="datetime-local" name="date_start" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_start">
                        </div>
                        
                        <div class="form-group">
                            <label for="date_end" class="block text-gray-700 font-semibold mb-2">{{ __('Date de fin souhaitée') }}</label>
                            <input type="datetime-local" name="date_end" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="date_end">
                        </div>
                    </div>
                </div>
                
                <div class="form-group mb-4">
                    <input type="hidden" name="status" id="status" value="pending">
                </div>
                
                <div class="form-group mb-6">
                    <label for="priority_id" class="block text-gray-700 font-semibold mb-2">{{ __('Priorité') }} <span class="text-red-500">*</span></label>
                    <select name="priority_id" class="form-control w-full border border-gray-300 rounded px-4 py-2" id="priority_id" required>
                        @foreach($priorities as $priority)
                            <option value="{{ $priority->id }}">{{ $priority->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="flex justify-end mt-6">
                    <a href="{{ route('consultation_requests.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded mr-2">
                        {{ __('Annuler') }}
                    </a>
                    <button type="submit" class="bg-indigo-700 hover:bg-indigo-800 text-white px-4 py-2 rounded">
                        {{ __('Soumettre la demande') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal de recherche de documents -->
    <div id="documentModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center hidden">
        <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col">
            <div class="p-4 border-b border-gray-200 flex justify-between items-center">
                <h3 class="text-lg font-semibold">{{ __('Rechercher un document') }}</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-4 border-b border-gray-200">
                <div class="flex w-full">
                    <input type="text" id="documentSearch" class="w-full border border-gray-300 rounded-l px-4 py-2" placeholder="{{ __('Rechercher par titre, référence, thématique...') }}">
                    <button id="searchButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                </div>
            </div>
            
            <div class="overflow-auto flex-grow p-4">
                <div id="documentResults" class="grid grid-cols-1 gap-4">
                    @foreach($documents as $document)
                        <div class="document-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer" 
                             data-id="{{ $document->id }}"
                             data-title="{{ $document->title }}"
                             data-reference="{{ $document->reference ?? '' }}"
                             data-date="{{ \Carbon\Carbon::parse($document->date)->format('d/m/Y') }}">
                            <h4 class="font-medium">{{ $document->title }}</h4>
                            @if($document->reference)
                                <p class="text-sm text-gray-500">Référence: {{ $document->reference }}</p>
                            @endif
                            <p class="text-sm text-gray-500">Date: {{ \Carbon\Carbon::parse($document->date)->format('d/m/Y') }}</p>
                            @if($document->theme)
                                <p class="text-sm text-gray-500">Thématique: {{ $document->theme }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const hasDocumentCheckbox = document.getElementById('hasDocument');
            const documentSelection = document.getElementById('documentSelection');
            const noDocumentForm = document.getElementById('noDocumentForm');
            const openModalButton = document.getElementById('openDocumentModal');
            const documentModal = document.getElementById('documentModal');
            const closeModalButton = document.getElementById('closeModal');
            const searchButton = document.getElementById('searchButton');
            const documentSearch = document.getElementById('documentSearch');
            const documentResults = document.getElementById('documentResults');
            const selectedDocument = document.getElementById('selectedDocument');
            const selectedDocumentId = document.getElementById('selected_document_id');
            const removeDocumentButton = document.getElementById('removeDocument');
            const docTitle = document.getElementById('doc_title');
            const docReference = document.getElementById('doc_reference');
            const docDate = document.getElementById('doc_date');
            
            // Toggle document selection
            hasDocumentCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    documentSelection.classList.remove('hidden');
                    // Cacher les champs date_start et date_end
                    if (selectedDocumentId.value) {
                        noDocumentForm.classList.add('hidden');
                    }
                } else {
                    documentSelection.classList.add('hidden');
                    noDocumentForm.classList.remove('hidden');
                    // Réinitialiser la sélection
                    selectedDocument.classList.add('hidden');
                    selectedDocumentId.value = '';
                }
            });
            
            // Open modal
            openModalButton.addEventListener('click', function() {
                documentModal.classList.remove('hidden');
                documentSearch.focus();
            });
            
            // Close modal
            closeModalButton.addEventListener('click', function() {
                documentModal.classList.add('hidden');
            });
            
            // Close modal on outside click
            documentModal.addEventListener('click', function(e) {
                if (e.target === documentModal) {
                    documentModal.classList.add('hidden');
                }
            });
            
            // Search functionality
            searchButton.addEventListener('click', searchDocuments);
            documentSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    searchDocuments();
                }
            });
            
            function searchDocuments() {
                const searchTerm = documentSearch.value.toLowerCase();
                
                // Find all document items
                const items = document.querySelectorAll('.document-item');
                
                items.forEach(item => {
                    const title = item.getAttribute('data-title').toLowerCase();
                    const reference = item.getAttribute('data-reference').toLowerCase();
                    
                    // Show/hide based on search term
                    if (title.includes(searchTerm) || reference.includes(searchTerm)) {
                        item.classList.remove('hidden');
                    } else {
                        item.classList.add('hidden');
                    }
                });
            }
            
            // Select a document
            documentResults.addEventListener('click', function(e) {
                const item = e.target.closest('.document-item');
                if (!item) return;
                
                const id = item.getAttribute('data-id');
                const title = item.getAttribute('data-title');
                const reference = item.getAttribute('data-reference');
                const date = item.getAttribute('data-date');
                
                // Set values
                selectedDocumentId.value = id;
                docTitle.textContent = title;
                docReference.textContent = reference ? 'Référence: ' + reference : '';
                docDate.textContent = 'Date: ' + date;
                
                // Show selection and hide other form fields
                selectedDocument.classList.remove('hidden');
                noDocumentForm.classList.add('hidden');
                
                // Close modal
                documentModal.classList.add('hidden');
            });
            
            // Remove selected document
            removeDocumentButton.addEventListener('click', function() {
                selectedDocument.classList.add('hidden');
                selectedDocumentId.value = '';
                noDocumentForm.classList.remove('hidden');
            });
        });
    </script>
    @endpush
@endsection
