<?php
// app/Http/Controllers/ConsultationRequestController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ConsultationAnswer;
use App\Models\ConsultationRequest;
use App\Models\Priority;
use App\Models\UserFile;
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

        $consultationRequests = $query->paginate(100);
        return view('consultation_requests.index', compact('consultationRequests'));
    }
    public function indexByUser(Request $request)
    {
        $search = $request->input('search');
        $userId = auth()->id();

        $query = ConsultationRequest::where('user_id', $userId);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', '%' . $search . '%')
                    ->orWhereHas('priority', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    })
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', '%' . $search . '%');
                    });
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
        ]);

        $consultationRequest = new ConsultationRequest();
        $consultationRequest->description = $request->description;
        $consultationRequest->date_start = $request->date_start;
        $consultationRequest->date_end = $request->date_end;
        $consultationRequest->status = $request->status;
        $consultationRequest->user_id = Auth::id();
        $consultationRequest->priority_id = $request->priority_id;
        $consultationRequest->created_by = Auth::id();
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        // Créer une réponse automatique
        $message = "VOTRE DEMANDE A ÉTÉ EFFECTUÉE AVEC SUCCÈS. VOUS SEREZ NOTIFIÉ SUR LES RÉSULTATS DE LA RECHERCHE INCESSAMMENT.";
        $this->createAutoResponse($consultationRequest, $message);

        return redirect()->route('consultation_requests.index')->with('success', 'Demande de consultation créée avec succès.');
    }

    public function reject(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->status = 'rejected';
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        $message = "NOUS SOMMES DÉSOLÉS DE NE POUVOIR DONNER SUITE À VOTRE DEMANDE. LES DOCUMENTS DEMANDÉS SONT INTROUVABLES/SONT CLASSÉS CONFIDENTIELS/INEXPLOITABLES POUR CAUSE DE DÉTÉRIORATION AVANCÉE/NE SE TROUVENT PAS DANS NOS LOCAUX. PRIÈRE DE VOUS RENDRE À L'ADMINISTRATION INDIQUÉE POUR RECEVOIR LE DOCUMENT.";
        $this->createAutoResponse($consultationRequest, $message);

        return redirect()->back()->with('info', 'Demande de consultation rejetée.');
    }

    public function finish(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->status = 'finished';
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        $message = "VOTRE DEMANDE A ÉTÉ TRAITÉE AVEC SUCCÈS. CI-JOINT EN PDF LES DOCUMENTS DEMANDÉS. VEUILLEZ LES TÉLÉCHARGER POUR EXPLOITATION.";
        $this->createAutoResponse($consultationRequest, $message);

        return redirect()->back()->with('success', 'Demande de consultation terminée.');
    }

    private function createAutoResponse(ConsultationRequest $consultationRequest, string $message)
    {
        ConsultationAnswer::create([
            'description' => $message,
            'consultation_request_id' => $consultationRequest->id,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);
    }
    public function show(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->load('consultationAnswers.user', 'userFiles');
//        dd($consultationRequest);
        return view('consultation_requests.show', compact('consultationRequest'));
    }

    public function showDocument(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->load('consultationAnswers.user');
        return view('consultation_requests.document', compact('consultationRequest'));
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
//            'category_id' => 'required|exists:category,id',
        ]);

        $consultationRequest->description = $request->description;
        $consultationRequest->date_start = $request->date_start;
        $consultationRequest->date_end = $request->date_end;
        $consultationRequest->status = $request->status;
        $consultationRequest->priority_id = $request->priority_id;
//        $consultationRequest->category_id = $request->category_id;
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->route('consultation_requests.index')->with('success', 'Consultation request updated successfully.');
    }

    public function destroy(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->delete();
        return redirect()->route('consultation_requests.index')->with('success', 'Consultation request deleted successfully.');
    }
    public function showFile(ConsultationRequest $consultationRequest, UserFile $userFile)
    {
        return view('consultation_requests.showFile', compact('consultationRequest', 'userFile'));
    }

    public function sendToCommittee(ConsultationRequest $consultationRequest)
    {
        $consultationRequest->status = 'comit';
        $consultationRequest->updated_by = Auth::id();
        $consultationRequest->save();

        return redirect()->back()->with('success', 'Consultation request sent to committee successfully.');
    }

//    public function reject(ConsultationRequest $consultationRequest)
//    {
//        $consultationRequest->status = 'rejected';
//        $consultationRequest->updated_by = Auth::id();
//        $consultationRequest->save();
//
//        $message = "NOUS SOMMES DÉSOLÉS DE NE POUVOIR DONNER SUITE À VOTRE DEMANDE. LES DOCUMENTS DEMANDÉS SONT INTROUVABLES/SONT CLASSÉS CONFIDENTIELS/INEXPLOITABLES POUR CAUSE DE DÉTÉRIORATION AVANCÉE/NE SE TROUVENT PAS DANS NOS LOCAUX. PRIÈRE DE VOUS RENDRE À L'ADMINISTRATION INDIQUÉE POUR RECEVOIR LE DOCUMENT.";
//        return redirect()->back()->with('info', $message);
//    }

//    public function finish(ConsultationRequest $consultationRequest)
//    {
//        $consultationRequest->status = 'finished';
//        $consultationRequest->updated_by = Auth::id();
//        $consultationRequest->save();
//
//        $message = "VOTRE DEMANDE A ÉTÉ TRAITÉE AVEC SUCCÈS. CI-JOINT EN PDF LES DOCUMENTS DEMANDÉS. VEUILLEZ LES TÉLÉCHARGER POUR EXPLOITATION.";
//        return redirect()->back()->with('success', $message);
//    }

}
