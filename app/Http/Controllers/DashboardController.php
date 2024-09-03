<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationRequest;
use App\Models\User;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Fetch pending and accepted requests
        $pendingRequests = ConsultationRequest::where('status', 'pending')->count();
        $acceptedRequests = ConsultationRequest::where('status', 'accepted')->count();

        // Fetch total users
        $totalUsers = User::count();

        // Fetch total categories
        $totalCategories = Category::count();

        // Fetch average response time (example calculation)
        $averageResponseTime = '2 h';

        // Fetch satisfaction rate (example calculation)
        $satisfactionRate = 95; // Placeholder value, replace with actual calculation

        // Fetch statistics by category

        // Fetch statistics by user type
        $statisticsByUserType = ConsultationRequest::join('users', 'consultation_requests.user_id', '=', 'users.id')
            ->select('users.user_types_id', DB::raw('count(*) as total'))
            ->groupBy('users.user_types_id')
            ->with('userType:id,name')
            ->get();

        // Fetch statistics by period (example: last 30 days)
        $statisticsByPeriod = ConsultationRequest::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->get();

        return view('dashboard', compact(
            'pendingRequests',
            'acceptedRequests',
            'totalUsers',
            'totalCategories',
            'averageResponseTime',
            'satisfactionRate',
            'statisticsByUserType',
            'statisticsByPeriod'
        ));
    }

    public function printStatistics()
    {
        // Réutilisez la logique de la méthode index pour récupérer les statistiques
        $pendingRequests = ConsultationRequest::where('status', 'pending')->count();
        $acceptedRequests = ConsultationRequest::where('status', 'accepted')->count();
        $totalUsers = User::count();
        $totalCategories = Category::count();
        $averageResponseTime = '2 h'; // Remplacez par le calcul réel
        $satisfactionRate = 95; // Remplacez par le calcul réel



        $statisticsByUserType = ConsultationRequest::join('users', 'consultation_requests.user_id', '=', 'users.id')
            ->select('users.user_types_id', DB::raw('count(*) as total'))
            ->groupBy('users.user_types_id')
            ->with('userType:id,name')
            ->get();

        $statisticsByPeriod = ConsultationRequest::where('created_at', '>=', now()->subDays(30))
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->groupBy('date')
            ->get();

        // Ajoutez les informations supplémentaires pour l'impression
        $appName = config('app.name');
        $generatedAt = now();
        $generatedBy = auth()->user()->name;

        return view('dashboard.print', compact(
            'pendingRequests',
            'acceptedRequests',
            'totalUsers',
            'totalCategories',
            'averageResponseTime',
            'satisfactionRate',
            'statisticsByUserType',
            'statisticsByPeriod',
            'appName',
            'generatedAt',
            'generatedBy'
        ));
    }
}
