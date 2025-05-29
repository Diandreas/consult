<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    
    <!-- Polices vintage -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Special+Elite&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/classic/ckeditor.js"></script>
    <link rel="stylesheet" href="https://cdn.ckeditor.com/ckeditor5/43.0.0/ckeditor5.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Styles vintage */
        body {
            font-family: 'Playfair Display', serif;
            background-color: #f8f3e6;
            color: #3a3a3a;
        }
        
        .bg-vintage-primary {
            background-color: #d4c7b0;
        }
        
        .bg-vintage-secondary {
            background-color: #e8e1d4;
        }
        
        .vintage-shadow {
            box-shadow: 2px 2px 8px rgba(0, 0, 0, 0.1);
        }
        
        .vintage-card {
            background-color: #fff;
            border: 1px solid #d4c7b0;
            border-radius: 4px;
            position: relative;
        }
        
        .vintage-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23d4c7b0' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            opacity: 0.3;
            pointer-events: none;
            z-index: 0;
        }
        
        .vintage-header {
            font-family: 'Special Elite', cursive;
            color: #5c4738;
        }
        
        .vintage-button {
            background-color: #a08c76;
            color: #fff;
            border: 1px solid #7d6b5d;
            transition: all 0.3s;
        }
        
        .vintage-button:hover {
            background-color: #7d6b5d;
            color: #fff;
        }
        
        .vintage-border {
            border: 1px solid #d4c7b0;
        }
        
        .nav-link {
            color: #5c4738 !important;
        }
        
        .nav-link:hover {
            color: #a08c76 !important;
        }
    </style>
</head>
<body class="font-sans antialiased">
<div class="min-h-screen flex flex-col">
    @include('layouts.navigation')
    <div class="mt-4 text-center">
        <a href="{{ route('language.switch', 'en') }}" class="btn vintage-button me-2">English</a>
        <a href="{{ route('language.switch', 'fr') }}" class="btn vintage-button">Français</a>
    </div>

    <header class="bg-vintage-primary shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            @hasSection('header')
                @yield('header')
            @else
                @isset($header)
                    {{-- {{ $header }} --}}
                @else
                    <h2 class="font-semibold text-xl vintage-header leading-tight">
                        {{ config('app.name', 'Laravel') }}
                    </h2>
                @endisset
            @endif
        </div>
    </header>

    <main class="flex-grow">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="vintage-card overflow-hidden vintage-shadow sm:rounded-lg">
                    <div class="p-6 bg-vintage-secondary border-b vintage-border">
                        @yield('content')
                        @if(isset($slot))
                            {{ $slot }}
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer class="bg-vintage-primary shadow mt-auto">
        <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
            <p class="text-center text-sm text-gray-700">
                © {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.
            </p>
        </div>
    </footer>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Vérifier si l'élément #description existe avant d'initialiser CKEditor
        if (document.querySelector('#description')) {
            ClassicEditor
                .create(document.querySelector('#description'))
                .then(editor => {
                    // Ajouter un écouteur sur le formulaire pour s'assurer que le textarea est mis à jour
                    editor.model.document.on('change:data', () => {
                        const data = editor.getData();
                        document.querySelector('#description').value = data;
                    });
                    
                    // S'assurer que le textarea n'est pas complètement caché
                    const textarea = document.querySelector('#description');
                    textarea.style.position = 'absolute';
                    textarea.style.opacity = '0';
                    textarea.style.height = '0';
                    textarea.style.overflow = 'hidden';
                    textarea.style.pointerEvents = 'none';
                    // Supprimer display:none pour éviter l'erreur de validation
                    textarea.style.display = 'block';
                })
                .catch(error => {
                    console.error(error);
                });
        }
    });
</script>
@stack('scripts')
</body>
</html>
