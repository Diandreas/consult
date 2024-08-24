<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ConsultationAnswer;
use App\Models\ConsultationRequest;

class ConsultationAnswerController extends Controller
{

    public function index(Request $request)
    {
        $search = $request->input('search');
        $consultationAnswers = ConsultationAnswer::with('consultationRequest')
            ->where('description', 'like', "%$search%")
            ->paginate(10);

        return view('consultation_answers.index', compact('consultationAnswers'));
    }


    public function create(ConsultationRequest $consultationRequest)
    {
        $consultationRequests = ConsultationRequest::all();
        return view('consultation_answers.create', compact('consultationRequests','consultationRequest'));
    }


    public function show(ConsultationAnswer $consultationAnswer)
    {
        return view('consultation_answers.show', compact('consultationAnswer'));
    }
    public function edit(ConsultationAnswer $consultationAnswer)
{
    $consultationRequests = ConsultationRequest::all();
    return view('consultation_answers.edit', compact('consultationAnswer', 'consultationRequests'));
}
    public function store(Request $request)
    {
        $request->validate([
            'description' => 'required|string',
            'consultation_request_id' => 'required|exists:consultation_requests,id',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['updated_by'] = auth()->id();

        ConsultationAnswer::create($data);

        return redirect()->back()->with('success', 'Consultation answer created successfully.');
    }

    public function update(Request $request, ConsultationAnswer $consultationAnswer)
    {
        $request->validate([
            'description' => 'required|string',
        ]);

        $data = $request->all();
        $data['updated_by'] = auth()->id();

        $consultationAnswer->update($data);

        return redirect()->back()->with('success', 'Consultation answer updated successfully.');
    }

    public function destroy(ConsultationAnswer $consultationAnswer)
    {
        $consultationAnswer->delete();

        return redirect()->back()->with('success', 'Consultation answer deleted successfully.');
    }
}
