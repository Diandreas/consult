<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord administrateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Vue d'ensemble -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Demandes de consultation -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Demandes de consultation</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-blue-600">{{ $pendingRequests }}</p>
                                <p class="text-gray-600">En attente</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $acceptedRequests }}</p>
                                <p class="text-gray-600">Acceptées</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Statistiques générales -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistiques générales</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-indigo-600">{{ $totalUsers }}</p>
                                <p class="text-gray-600">Utilisateurs</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-pink-600">{{ $totalCategories }}</p>
                                <p class="text-gray-600">Catégories</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Performance -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Performance</h3>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="text-center">
                                <p class="text-3xl font-bold text-yellow-600">{{ $averageResponseTime }}</p>
                                <p class="text-gray-600">Temps de réponse moyen</p>
                            </div>
                            <div class="text-center">
                                <p class="text-3xl font-bold text-green-600">{{ $satisfactionRate }}%</p>
                                <p class="text-gray-600">Taux de satisfaction</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Graphique des statistiques par période -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Statistiques par période (30 derniers jours)</h3>
                    <canvas id="periodStats"></canvas>
                </div>
            </div>

            <!-- Statistiques détaillées -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Statistiques par catégorie -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistiques par catégorie</h3>
                        <div class="space-y-4">
                            @foreach ($statisticsByCategory as $statistic)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">{{ $statistic->category->name }}</span>
                                    <span class="text-xl font-bold text-blue-600">{{ $statistic->total }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Statistiques par type d'utilisateur -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold mb-4">Statistiques par type d'utilisateur</h3>
                        <div class="space-y-4">
                            @foreach ($statisticsByUserType as $statistic)
                                <div class="flex justify-between items-center">
                                    <span class="text-gray-600">{{ $statistic->userType->name ?? 'N/A' }}</span>
                                    <span class="text-xl font-bold text-blue-600">{{ $statistic->total }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions rapides -->
            <div class="mt-6 bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Actions rapides</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('consultation_requests.create') }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            Créer une nouvelle demande
                        </a>
                        <a href="{{ route('users.index') }}" class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            Gérer les utilisateurs
                        </a>
                        <a href="{{ route('consultation_requests.index') }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            Voir toutes les demandes
                        </a>
                        <a href="{{ route('dashboard.print') }}" target="_blank" class="flex-1 text-center bg-purple-500 hover:bg-purple-600 text-white font-bold py-2 px-4 rounded">
                            Imprimer les statistiques
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('periodStats').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: {!! json_encode($statisticsByPeriod->pluck('date')) !!},
                    datasets: [{
                        label: 'Nombre de consultations',
                        data: {!! json_encode($statisticsByPeriod->pluck('total')) !!},
                        borderColor: 'rgb(75, 192, 192)',
                        tension: 0.1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>
