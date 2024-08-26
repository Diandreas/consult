<?php

namespace App\Http\Controllers;

use App\Models\consultationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkflowController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $searchType = $request->input('search_type', 'all');
        $query = ConsultationRequest::query()->where('status', 'comit');

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
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
                    break;
                case 'description':
                    $query->where('description', 'like', '%' . $search . '%');
                    break;
                case 'all':
                default:
                    $query->where(function ($q) use ($search) {
                        $q->where('description', 'like', '%' . $search . '%')
                            ->orWhereHas('priority', function ($q) use ($search) {
                                $q->where('name', 'like', '%' . $search . '%');
                            })
                            ->orWhere('status', 'like', '%' . $search . '%')
                            ->orWhereHas('user', function ($q) use ($search) {
                                $q->where('name', 'like', '%' . $search . '%');
                            });
                    });
                    break;
            }
        }

        $consultationRequests = $query->paginate(10);
        return view('workflow.index', compact('consultationRequests'));
    }


    public function show(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->load('consultationAnswers.user', 'userFiles');
        return view('workflow.show', compact('consultationRequest'));
    }

    public function accept(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->status = 'accepted';
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->back()->with('success', 'Consultation request accepted successfully.');
    }
    public function reject(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->status = 'rejected';
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->back()->with('success', 'Consultation request rejected successfully.');
    }
}
