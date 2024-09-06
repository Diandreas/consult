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
        <h1 class="display-4">Bienvenue à la Consultation des Archives Nationales</h1>
        <p class="lead">Consultez et gérez les archives nationales en toute simplicité.</p>
        <hr class="my-4">
        <p>Cette application vous permet de consulter et de gérer les archives nationales. Vous pouvez soumettre des demandes de consultation, suivre leur statut et accéder aux réponses.</p>
        <p>Les archives nationales contiennent une vaste collection de documents historiques, administratifs, législatifs et culturels. Vous pouvez consulter des documents tels que des actes de naissance, des actes de mariage, des actes de décès, des documents militaires, des documents de propriété, des documents gouvernementaux, et bien plus encore.</p>
        <p>Notre système de gestion des demandes de consultation vous permet de soumettre des demandes pour accéder à ces documents, de suivre l'état de vos demandes et de recevoir des réponses détaillées. Que vous soyez un chercheur, un historien, un généalogiste ou simplement curieux, notre plateforme est conçue pour vous aider à accéder facilement aux informations dont vous avez besoin.</p>
        <a class="btn btn-primary btn-lg" href="{{ route('consultation_requests.index') }}" role="button">Consulter les Demandes</a>
    </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
