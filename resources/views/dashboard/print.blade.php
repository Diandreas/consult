<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Statistiques - {{ $appName }}</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { text-align: center; margin-bottom: 20px; }
        .statistics { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
<div class="header">
    <h1>{{ $appName }}</h1>
    <p>Généré le : {{ $generatedAt->format('d/m/Y H:i:s') }}</p>
    <p>Par : {{ $generatedBy }}</p>
</div>

<div class="statistics">
    <h2>Statistiques</h2>

    <h3>Demandes de consultation</h3>
    <p>En attente : {{ $pendingRequests }}</p>
    <p>Acceptées : {{ $acceptedRequests }}</p>

    <h3>Statistiques générales</h3>
    <p>Utilisateurs : {{ $totalUsers }}</p>
    <p>Catégories : {{ $totalCategories }}</p>
    <p>Temps de réponse moyen : {{ $averageResponseTime }}</p>
    <p>Taux de satisfaction : {{ $satisfactionRate }}%</p>



    <h3>Statistiques par type d'utilisateur</h3>
    <table>
        <tr>
            <th>Type d'utilisateur</th>
            <th>Total</th>
        </tr>
        @foreach ($statisticsByUserType as $statistic)
            <tr>
                <td>{{ $statistic->userType->name ?? 'N/A' }}</td>
                <td>{{ $statistic->total }}</td>
            </tr>
        @endforeach
    </table>

    <h3>Statistiques par période (30 derniers jours)</h3>
    <table>
        <tr>
            <th>Date</th>
            <th>Total</th>
        </tr>
        @foreach ($statisticsByPeriod as $statistic)
            <tr>
                <td>{{ $statistic->date }}</td>
                <td>{{ $statistic->total }}</td>
            </tr>
        @endforeach
    </table>
</div>
</body>
</html>
