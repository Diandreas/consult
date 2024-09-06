<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tableau de bord utilisateur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Welcome Message -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Bienvenue') }}, {{ auth()->user()->name }}!</h3>
                    {{--                    <p class="text-gray-600">Vous êtes connecté en tant que {{ auth()->user()->role->name }}.</p>--}}
                </div>
            </div>

            <!-- User Statistics -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Statistiques utilisateur') }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center">
                            <p class="text-2xl font-bold text-indigo-600">{{ $userRequestsCount }}</p>
                            <p class="text-gray-600">{{ __('Demandes de consultation') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-pink-600">{{ $userPendingRequests }}</p>
                            <p class="text-gray-600">{{ __('Demandes en attente') }}</p>
                        </div>
                        <div class="text-center">
                            <p class="text-2xl font-bold text-yellow-600">{{ $userAcceptedRequests }}</p>
                            <p class="text-gray-600">{{ __('Demandes acceptées') }}</p>
                        </div>
                        {{--                        <div class="text-center">--}}
                        {{--                            <p class="text-2xl font-bold text-green-600">{{ $userSatisfactionRate }}%</p>--}}
                        {{--                            <p class="text-gray-600">{{ __('Taux de satisfaction') }}</p>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Activité récente') }}</h3>
                    <ul class="space-y-2">
                        @forelse($recentActivities as $activity)
                            <li class="text-sm text-gray-600">{{ $activity }}</li>
                        @empty
                            <li class="text-sm text-gray-600">{{ __('Aucune activité récente') }}</li>
                        @endforelse
                    </ul>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">{{ __('Actions rapides') }}</h3>
                    <div class="flex space-x-4">
                        <a href="{{ route('consultation_requests.create') }}" class="flex-1 text-center bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('Créer une nouvelle demande') }}
                        </a>
                        <a href="{{ route('profile.edit') }}" class="flex-1 text-center bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('Modifier le profil') }}
                        </a>
                        <a href="{{ route('consultation_requests.indexByUser') }}" class="flex-1 text-center bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded">
                            {{ __('Voir toutes mes demandes') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
