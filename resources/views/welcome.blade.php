<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Consultation des Archives Nationales</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
    </style>
</head>
<body class="antialiased">
<div class="container mt-5">
    <div class="jumbotron">
        <div class="mt-4 text-center">
            <a href="{{ route('language.switch', 'en') }}" class="btn btn-outline-primary me-2">English</a>
            <a href="{{ route('language.switch', 'fr') }}" class="btn btn-outline-primary">Français</a>
        </div>
        <h1 class="display-4">{{ __('Bienvenue') }}</h1>
        <p class="lead">{{ __('Consultation Requests') }}</p>
        <hr class="my-4">
        <p>{{ __('This application allows you to consult and manage national archives. You can submit consultation requests, track their status, and access responses.') }}</p>
        <p>{{ __('The national archives contain a vast collection of historical, administrative, legislative, and cultural documents. You can consult documents such as birth certificates, marriage certificates, death certificates, military documents, property documents, government documents, and much more.') }}</p>
        <p>{{ __('Our consultation request management system allows you to submit requests to access these documents, track the status of your requests, and receive detailed responses. Whether you are a researcher, historian, genealogist, or simply curious, our platform is designed to help you easily access the information you need.') }}</p>
        <a class="btn btn-primary btn-lg" href="{{ route('consultation_requests.index') }}" role="button">{{ __('Consult Requests') }}</a>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
