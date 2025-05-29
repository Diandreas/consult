@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="text-2xl font-bold mb-4">{{ __('Créer une demande de consultation') }}</h1>
        
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <form id="consultationForm" action="{{ route('consultation_requests.store') }}" method="POST">
                @csrf
                
                <!-- Sélection de document -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-semibold mb-2">{{ __('Document du catalogue') }}</label>
                    
                    <div class="flex items-start mb-4">
                        <div class="flex items-center h-5">
                            <input id="hasDocument" type="checkbox" class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                        </div>
                        <label for="hasDocument" class="ml-2 text-sm font-medium text-gray-700">
                            {{ __('Je souhaite consulter un document du catalogue') }}
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
                <h3 class="text-lg font-semibold">{{ __('Rechercher un document du catalogue') }}</h3>
                <button id="closeModal" class="text-gray-500 hover:text-gray-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            
            <div class="p-4 border-b border-gray-200">
                <div class="flex flex-col md:flex-row gap-2">
                    <div class="flex w-full">
                        <input type="text" id="documentSearch" class="w-full border border-gray-300 rounded-l px-4 py-2" placeholder="{{ __('Rechercher par titre, référence, thématique...') }}">
                        <button id="searchButton" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                    
                    <div class="flex space-x-2">
                        <select id="filterTheme" class="border border-gray-300 rounded px-3 py-2 text-sm">
                            <option value="">Toutes thématiques</option>
                            <option value="administration">Administration</option>
                            <option value="finances">Finances</option>
                            <option value="juridique">Juridique</option>
                        </select>
                        
                        <select id="filterYear" class="border border-gray-300 rounded px-3 py-2 text-sm">
                            <option value="">Toutes années</option>
                            <option value="2023">2023</option>
                            <option value="2022">2022</option>
                            <option value="2021">2021</option>
                            <option value="2020">2020</option>
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="overflow-auto flex-grow p-4">
                <div id="documentResults" class="grid grid-cols-1 gap-4">
                    <div id="resultsPlaceholder" class="text-center py-8 text-gray-500">
                        <p>Saisissez au moins 3 caractères pour lancer la recherche</p>
                    </div>
                    
                    <div id="resultsList" class="hidden">
                        <!-- Les résultats seront chargés ici dynamiquement -->
                    </div>
                    
                    <div id="loadingIndicator" class="hidden text-center py-4">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
                        <p class="mt-2 text-gray-600">Chargement des résultats...</p>
                    </div>
                    
                    <div id="noResults" class="hidden text-center py-8 text-gray-500">
                        <p>Aucun document trouvé correspondant à votre recherche</p>
                    </div>
                </div>
                
                <!-- Pagination -->
                <div id="pagination" class="hidden mt-6 flex justify-center">
                    <nav class="flex items-center">
                        <button id="prevPage" class="px-3 py-1 rounded-l border border-gray-300 bg-gray-50 text-gray-500 hover:bg-gray-100 disabled:opacity-50">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                        <div id="paginationInfo" class="px-4 py-1 border-t border-b border-gray-300 bg-gray-50 text-gray-700 text-sm">
                            Page <span id="currentPage">1</span> sur <span id="totalPages">1</span>
                        </div>
                        <button id="nextPage" class="px-3 py-1 rounded-r border border-gray-300 bg-gray-50 text-gray-500 hover:bg-gray-100 disabled:opacity-50">
                            <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>
                    </nav>
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
            const resultsList = document.getElementById('resultsList');
            const resultsPlaceholder = document.getElementById('resultsPlaceholder');
            const loadingIndicator = document.getElementById('loadingIndicator');
            const noResults = document.getElementById('noResults');
            const selectedDocument = document.getElementById('selectedDocument');
            const selectedDocumentId = document.getElementById('selected_document_id');
            const removeDocumentButton = document.getElementById('removeDocument');
            const docTitle = document.getElementById('doc_title');
            const docReference = document.getElementById('doc_reference');
            const docDate = document.getElementById('doc_date');
            const filterTheme = document.getElementById('filterTheme');
            const filterYear = document.getElementById('filterYear');
            
            // Pagination elements
            const pagination = document.getElementById('pagination');
            const prevPageButton = document.getElementById('prevPage');
            const nextPageButton = document.getElementById('nextPage');
            const currentPageSpan = document.getElementById('currentPage');
            const totalPagesSpan = document.getElementById('totalPages');
            
            // Variables de pagination
            let currentPage = 1;
            let totalPages = 1;
            let documentsPerPage = 10;
            let allDocuments = [];
            let filteredDocuments = [];
            
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
                // Charger tous les documents au premier chargement
                if (allDocuments.length === 0) {
                    fetchDocuments();
                }
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
            
            // Fetch documents from server
            function fetchDocuments() {
                // Ici vous devriez faire un appel AJAX à votre backend pour récupérer les documents
                // Pour l'exemple, nous allons simuler cela avec un délai
                
                loadingIndicator.classList.remove('hidden');
                resultsPlaceholder.classList.add('hidden');
                resultsList.classList.add('hidden');
                noResults.classList.add('hidden');
                
                // Simuler un chargement (remplacer par un vrai appel AJAX)
                setTimeout(() => {
                    // Simulation de données - Dans une implémentation réelle, cela viendrait du serveur
                    allDocuments = @json($documents);
                    
                    // Après avoir récupéré les documents
                    loadingIndicator.classList.add('hidden');
                    
                    // Appliquer les filtres initiaux et afficher les résultats
                    applyFiltersAndSearch();
                }, 500);
            }
            
            // Appliquer les filtres et la recherche
            function applyFiltersAndSearch() {
                const searchTerm = documentSearch.value.toLowerCase();
                const themeFilter = filterTheme.value.toLowerCase();
                const yearFilter = filterYear.value;
                
                // Filtrer les documents
                filteredDocuments = allDocuments.filter(doc => {
                    const matchesSearch = searchTerm.length < 3 || 
                                        doc.title.toLowerCase().includes(searchTerm) || 
                                        (doc.reference && doc.reference.toLowerCase().includes(searchTerm)) ||
                                        (doc.theme && doc.theme.toLowerCase().includes(searchTerm));
                    
                    const matchesTheme = !themeFilter || (doc.theme && doc.theme.toLowerCase().includes(themeFilter));
                    
                    const docYear = doc.date ? new Date(doc.date).getFullYear().toString() : '';
                    const matchesYear = !yearFilter || docYear === yearFilter;
                    
                    return matchesSearch && matchesTheme && matchesYear;
                });
                
                // Mise à jour de la pagination
                totalPages = Math.max(1, Math.ceil(filteredDocuments.length / documentsPerPage));
                currentPage = 1;
                updatePagination();
                
                // Afficher les résultats
                displayResults();
            }
            
            // Mise à jour de l'interface de pagination
            function updatePagination() {
                currentPageSpan.textContent = currentPage;
                totalPagesSpan.textContent = totalPages;
                
                // Activer/désactiver les boutons de pagination
                prevPageButton.disabled = currentPage === 1;
                nextPageButton.disabled = currentPage === totalPages;
                
                // Afficher ou cacher la pagination selon le nombre de résultats
                if (filteredDocuments.length > documentsPerPage) {
                    pagination.classList.remove('hidden');
                } else {
                    pagination.classList.add('hidden');
                }
            }
            
            // Afficher les résultats paginés
            function displayResults() {
                // Vider la liste des résultats
                resultsList.innerHTML = '';
                
                // Si aucun résultat
                if (filteredDocuments.length === 0) {
                    noResults.classList.remove('hidden');
                    resultsList.classList.add('hidden');
                    return;
                }
                
                // Calculer les indices de début et fin pour la pagination
                const startIndex = (currentPage - 1) * documentsPerPage;
                const endIndex = Math.min(startIndex + documentsPerPage, filteredDocuments.length);
                
                // Afficher les documents de la page courante
                for (let i = startIndex; i < endIndex; i++) {
                    const doc = filteredDocuments[i];
                    const docElement = createDocumentElement(doc);
                    resultsList.appendChild(docElement);
                }
                
                noResults.classList.add('hidden');
                resultsList.classList.remove('hidden');
            }
            
            // Créer un élément de document pour l'affichage
            function createDocumentElement(doc) {
                const div = document.createElement('div');
                div.className = 'document-item p-4 border border-gray-200 rounded-lg hover:bg-gray-50 cursor-pointer';
                div.setAttribute('data-id', doc.id);
                div.setAttribute('data-title', doc.title);
                div.setAttribute('data-reference', doc.reference || '');
                
                // Formater la date
                const dateObj = new Date(doc.date);
                const formattedDate = `${dateObj.getDate().toString().padStart(2, '0')}/${(dateObj.getMonth() + 1).toString().padStart(2, '0')}/${dateObj.getFullYear()}`;
                div.setAttribute('data-date', formattedDate);
                
                // Créer le contenu de l'élément
                div.innerHTML = `
                    <h4 class="font-medium">${doc.title}</h4>
                    ${doc.reference ? `<p class="text-sm text-gray-500">Référence: ${doc.reference}</p>` : ''}
                    <p class="text-sm text-gray-500">Date: ${formattedDate}</p>
                    ${doc.theme ? `<p class="text-sm text-gray-500">Thématique: ${doc.theme}</p>` : ''}
                `;
                
                // Ajouter l'event listener pour la sélection
                div.addEventListener('click', function() {
                    selectDocument(doc.id, doc.title, doc.reference || '', formattedDate);
                });
                
                return div;
            }
            
            // Sélectionner un document
            function selectDocument(id, title, reference, date) {
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
            }
            
            // Search button event
            searchButton.addEventListener('click', function() {
                applyFiltersAndSearch();
            });
            
            // Search input event
            documentSearch.addEventListener('keyup', function(e) {
                if (e.key === 'Enter') {
                    applyFiltersAndSearch();
                }
            });
            
            // Filter change events
            filterTheme.addEventListener('change', applyFiltersAndSearch);
            filterYear.addEventListener('change', applyFiltersAndSearch);
            
            // Pagination events
            prevPageButton.addEventListener('click', function() {
                if (currentPage > 1) {
                    currentPage--;
                    updatePagination();
                    displayResults();
                }
            });
            
            nextPageButton.addEventListener('click', function() {
                if (currentPage < totalPages) {
                    currentPage++;
                    updatePagination();
                    displayResults();
                }
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
