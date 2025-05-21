<?php

namespace App\Http\Controllers;

use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DocumentTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $query = DocumentType::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $documentTypes = $query->paginate(15);
        return view('document_types.index', compact('documentTypes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('document_types.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_types',
            'description' => 'nullable|string',
        ]);

        $documentType = new DocumentType();
        $documentType->name = $request->name;
        $documentType->description = $request->description;
        $documentType->save();

        return redirect()->route('document-types.index')
            ->with('success', 'Type de document créé avec succès.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function show(DocumentType $documentType)
    {
        return view('document_types.show', compact('documentType'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function edit(DocumentType $documentType)
    {
        return view('document_types.edit', compact('documentType'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DocumentType $documentType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_types,name,' . $documentType->id,
            'description' => 'nullable|string',
        ]);

        $documentType->name = $request->name;
        $documentType->description = $request->description;
        $documentType->save();

        return redirect()->route('document-types.index')
            ->with('success', 'Type de document mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DocumentType  $documentType
     * @return \Illuminate\Http\Response
     */
    public function destroy(DocumentType $documentType)
    {
        // Vérifier si des documents utilisent ce type
        $documentsCount = $documentType->documents()->count();
        if ($documentsCount > 0) {
            return redirect()->route('document-types.index')
                ->with('error', 'Impossible de supprimer ce type de document car il est utilisé par ' . $documentsCount . ' document(s).');
        }

        $documentType->delete();
        return redirect()->route('document-types.index')
            ->with('success', 'Type de document supprimé avec succès.');
    }
} 