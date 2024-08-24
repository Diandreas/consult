<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationRequest;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch user-specific statistics
        $userRequestsCount = ConsultationRequest::where('user_id', $user->id)->count();
        $userPendingRequests = ConsultationRequest::where('user_id', $user->id)->where('status', 'pending')->count();
        $userAcceptedRequests = ConsultationRequest::where('user_id', $user->id)->where('status', 'accepted')->count();
        $userSatisfactionRate = 85; // Placeholder value, replace with actual calculation

        // Fetch recent activities (example)
        $recentActivities = [
            'Demande de consultation créée le 2023-10-01',
            'Demande de consultation acceptée le 2023-10-02',
            // Add more activities as needed
        ];

        return view('home', compact(
            'userRequestsCount',
            'userPendingRequests',
            'userAcceptedRequests',
            'userSatisfactionRate',
            'recentActivities'
        ));
    }
}
