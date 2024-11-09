<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen">
<main class="container mx-auto px-4 py-8 flex items-center justify-center min-h-screen">
    <div class="w-full max-w-4xl bg-white rounded-2xl shadow-xl overflow-hidden">
        <div class="flex flex-col md:flex-row">
            <!-- Section de gauche (Logo et info) -->
            <div class="md:w-1/3 bg-gradient-to-b from-blue-600 to-blue-800 p-8 text-white">
                <div class="mb-8 flex justify-center">
                    <a href="/">
                        <x-application-logo class="w-24 h-24 fill-current text-white" />
                    </a>
                </div>
                <h2 class="text-2xl font-bold mb-4">Bienvenue sur {{ config('app.name') }}</h2>
                <p class="text-blue-100 mb-4">Créez votre compte ou connectez-vous pour accéder à nos services.</p>
                <div class="mt-8">
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Interface sécurisée</span>
                    </div>
                    <div class="flex items-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        <span>Protection des données</span>
                    </div>
                </div>
            </div>

            <!-- Section de droite (Formulaires) -->
            <div class="md:w-2/3 p-8">
                <!-- Onglets -->
                <div class="flex mb-8 border-b">
                    <button
                        onclick="switchTab('login')"
                        id="login-tab"
                        class="px-4 py-2 font-semibold border-b-2 border-blue-600 text-blue-600">
                        Connexion
                    </button>
                    <button
                        onclick="switchTab('register')"
                        id="register-tab"
                        class="px-4 py-2 font-semibold text-gray-500">
                        Inscription
                    </button>
                </div>

                <!-- Formulaire de connexion -->
                <div id="login-form" class="space-y-6">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="login-email" :value="__('Email')" />
                                <x-text-input
                                    id="login-email"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="votre@email.com"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="login-password" :value="__('Mot de passe')" />
                                <x-text-input
                                    id="login-password"
                                    type="password"
                                    name="password"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="••••••••"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div class="flex items-center justify-between">
                                <label class="flex items-center">
                                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                                </label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:text-blue-800">
                                        Mot de passe oublié ?
                                    </a>
                                @endif
                            </div>

                            <x-primary-button class="w-full justify-center py-3">
                                {{ __('Se connecter') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>

                <!-- Formulaire d'inscription -->
                <div id="register-form" class="hidden space-y-6">
                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Type d'utilisateur -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Type de compte</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                    <input type="radio" name="account_type" value="particular" class="mr-2" required>
                                    <div>
                                        <div class="font-medium">Particulier</div>
                                        <div class="text-sm text-gray-500">Compte personnel</div>
                                    </div>
                                </label>
                                <label class="flex items-center p-4 border rounded-lg cursor-pointer hover:border-blue-500 transition-colors">
                                    <input type="radio" name="account_type" value="company" class="mr-2">
                                    <div>
                                        <div class="font-medium">Entreprise</div>
                                        <div class="text-sm text-gray-500">Compte professionnel</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Informations de base -->
                        <div class="space-y-4">
                            <div>
                                <x-input-label for="name" :value="__('Nom complet')" />
                                <x-text-input
                                    id="name"
                                    type="text"
                                    name="name"
                                    :value="old('name')"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg"
                                    placeholder="John Doe"
                                />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email')" />
                                <x-text-input
                                    id="email"
                                    type="email"
                                    name="email"
                                    :value="old('email')"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg"
                                    placeholder="votre@email.com"
                                />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>

                            <!-- Champs entreprise (conditionnels) -->
                            <div id="company-fields" class="hidden space-y-4">
                                <div>
                                    <x-input-label for="company_name" :value="__('Nom de l\'entreprise')" />
                                    <x-text-input
                                        id="company_name"
                                        type="text"
                                        name="company_name"
                                        :value="old('company_name')"
                                        class="block w-full px-4 py-3 rounded-lg"
                                    />
                                </div>
                                <div>
                                    <x-input-label for="company_registration" :value="__('Numéro SIRET')" />
                                    <x-text-input
                                        id="company_registration"
                                        type="text"
                                        name="company_registration"
                                        :value="old('company_registration')"
                                        class="block w-full px-4 py-3 rounded-lg"
                                    />
                                </div>
                                <div>
                                    <x-input-label for="company_documents" :value="__('Documents d\'entreprise (Kbis, etc.)')" />
                                    <input
                                        type="file"
                                        name="company_documents[]"
                                        multiple
                                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg"
                                        accept=".pdf,.doc,.docx"
                                    />
                                </div>
                            </div>

                            <!-- CNI Upload -->
                            <div>
                                <x-input-label for="id_card" :value="__('Carte d\'identité (recto/verso)')" />
                                <input
                                    type="file"
                                    name="id_card[]"
                                    multiple
                                    required
                                    class="block w-full px-4 py-3 border border-gray-300 rounded-lg"
                                    accept="image/*,.pdf"
                                />
                                <p class="mt-1 text-sm text-gray-500">Formats acceptés : JPG, PNG, PDF</p>
                            </div>

                            <div>
                                <x-input-label for="password" :value="__('Mot de passe')" />
                                <x-text-input
                                    id="password"
                                    type="password"
                                    name="password"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg"
                                />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" />
                                <x-text-input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    required
                                    class="block w-full px-4 py-3 rounded-lg"
                                />
                            </div>

                            <div class="flex items-center">
                                <input
                                    type="checkbox"
                                    id="terms"
                                    name="terms"
                                    required
                                    class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                >
                                <label for="terms" class="ml-2 text-sm text-gray-600">
                                    J'accepte les <a href="#" class="text-blue-600 hover:text-blue-800">conditions d'utilisation</a>
                                </label>
                            </div>

                            <x-primary-button class="w-full justify-center py-3">
                                {{ __('S\'inscrire') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<script>
    function switchTab(tab) {
        // Mise à jour des onglets
        document.getElementById('login-tab').classList.remove('border-blue-600', 'text-blue-600');
        document.getElementById('register-tab').classList.remove('border-blue-600', 'text-blue-600');
        document.getElementById(`${tab}-tab`).classList.add('border-blue-600', 'text-blue-600');

        // Affichage du formulaire approprié
        document.getElementById('login-form').classList.add('hidden');
        document.getElementById('register-form').classList.add('hidden');
        document.getElementById(`${tab}-form`).classList.remove('hidden');
    }

    // Gestion des champs d'entreprise
    document.querySelectorAll('input[name="account_type"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const companyFields = document.getElementById('company-fields');
            if (this.value === 'company') {
                companyFields.classList.remove('hidden');
            } else {
                companyFields.classList.add('hidden');
            }
        });
    });
</script>
</body>
</html>
