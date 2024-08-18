<?php

// app/Http/Controllers/ConsultationAnswerController.php

namespace App\Http\Controllers;

use App\Models\ConsultationAnswer;
use Illuminate\Http\Request;

class ConsultationAnswerController extends Controller
{
    public function index()
    {
        $consultationAnswers = ConsultationAnswer::all();
        return view('consultation_answers.index', compact('consultationAnswers'));
    }

    public function create()
    {
        return view('consultation_answers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'description' => 'nullable|string',
            'consultation_request_id' => 'required|exists:consultation_requests,id',
        ]);

        ConsultationAnswer::create($request->all());

        return redirect()->route('consultation_answers.index')->with('success', 'ConsultationAnswer created successfully.');
    }

    public function show(ConsultationAnswer $consultationAnswer)
    {
        return view('consultation_answers.show', compact('consultationAnswer'));
    }

    public function edit(ConsultationAnswer $consultationAnswer)
    {
        return view('consultation_answers.edit', compact('consultationAnswer'));
    }

    public function update(Request $request, ConsultationAnswer $consultationAnswer)
    {
        $request->validate([
            'description' => 'nullable|string',
            'consultation_request_id' => 'required|exists:consultation_requests,id',
        ]);

        $consultationAnswer->update($request->all());

        return redirect()->route('consultation_answers.index')->with('success', 'ConsultationAnswer updated successfully.');
    }

    public function destroy(ConsultationAnswer $consultationAnswer)
    {
        $consultationAnswer->delete();

        return redirect()->route('consultation_answers.index')->with('success', 'ConsultationAnswer deleted successfully.');
    }
}
