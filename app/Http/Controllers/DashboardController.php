<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ConsultationRequest;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchType = $request->input('search_type', 'all');
        $query = ConsultationRequest::query();

        if ($search) {
            switch ($searchType) {
                case 'priority':
                    $query->whereHas('priority', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
                    break;
                case 'status':
                    $query->where('status', 'like', '%' . $search . '%');
                    break;
                case 'name':
                    $query->where('name', 'like', '%' . $search . '%');
                    break;
                case 'description':
                    $query->where('description', 'like', '%' . $search . '%');
                    break;
                default:
                    $query->where(function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%')
                            ->orWhere('description', 'like', '%' . $search . '%')
                            ->orWhere('status', 'like', '%' . $search . '%')
                            ->orWhereHas('priority', function ($sq) use ($search) {
                                $sq->where('name', 'like', '%' . $search . '%');
                            });
                    });
            }
        }

        $consultationRequests = $query->paginate(10);
        return view('consultation_requests.index', compact('consultationRequests', 'search', 'searchType'));
    }
// Implement these methods based on your specific requirements
    private function getRecentActivities()
    {
        // Return an array of recent activities
        return ['Activity 1', 'Activity 2', 'Activity 3'];
    }

    private function calculateAverageResponseTime()
    {
        // Calculate and return average response time
        return '2 hours';
    }

    private function calculateSatisfactionRate()
    {
        // Calculate and return satisfaction rate
        return 95;
    }
}
