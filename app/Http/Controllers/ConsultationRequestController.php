<?php
// app/Http/Controllers/ConsultationRequestController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ConsultationRequest;
use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationRequestController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = ConsultationRequest::query();

        if ($search) {
            $query->whereHas('priority', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%');
            });
        }

        $consultationRequests = $query->paginate(10);
        return view('consultation_requests.index', compact('consultationRequests'));
    }

    public function create()
    {
        $priorities = Priority::all();
        $categories = Category::all();
        return view('consultation_requests.create', compact('priorities', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'status' => 'nullable|string|max:45',
            'priority_id' => 'required|exists:priority,id',
            'category_id' => 'required|exists:category,id',
        ]);

        $consultationRequest = new ConsultationRequest();
        $consultationRequest->description = $request->description;
        $consultationRequest->date_start = $request->date_start;
        $consultationRequest->date_end = $request->date_end;
        $consultationRequest->status = $request->status;
        $consultationRequest->user_id = Auth::id();
        $consultationRequest->priority_id = $request->priority_id;
        $consultationRequest->category_id = $request->category_id;
        $consultationRequest->created_by = Auth::id();
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->route('consultation_requests.index')->with('success', 'Consultation request created successfully.');
    }

    public function show(ConsultationRequest $consultationRequest)
    {
        return view('consultation_requests.show', compact('consultationRequest'));
    }

    public function edit(ConsultationRequest $consultationRequest)
    {
        $priorities = Priority::all();
        $categories = Category::all();
        return view('consultation_requests.edit', compact('consultationRequest', 'priorities', 'categories'));
    }

    public function update(Request $request, ConsultationRequest $consultationRequest)
    {
        $request->validate([
            'description' => 'nullable|string',
            'date_start' => 'nullable|date',
            'date_end' => 'nullable|date',
            'status' => 'nullable|string|max:45',
            'priority_id' => 'required|exists:priority,id',
            'category_id' => 'required|exists:category,id',
        ]);

        $consultationRequest->description = $request->description;
        $consultationRequest->date_start = $request->date_start;
        $consultationRequest->date_end = $request->date_end;
        $consultationRequest->status = $request->status;
        $consultationRequest->priority_id = $request->priority_id;
        $consultationRequest->category_id = $request->category_id;
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->route('consultation_requests.index')->with('success', 'Consultation request updated successfully.');
    }

    public function destroy(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->delete();
        return redirect()->route('consultation_requests.index')->with('success', 'Consultation request deleted successfully.');
    }
}
