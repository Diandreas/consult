<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\DocumentType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DocumentController extends Controller
{
    /**
     * Display a listing of the documents.
     */
    public function index()
    {
        $documents = Document::with('documentType')->latest()->paginate(10);
        return view('documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document.
     */
    public function create()
    {
        $documentTypes = DocumentType::all();
        return view('documents.create', compact('documentTypes'));
    }

    /**
     * Store a newly created document in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'title_analysis' => 'nullable|string|max:255',
            'date' => 'required|date',
            'document_type_id' => 'required|exists:document_types,id',
            'description' => 'required|string',
            'content_presentation' => 'nullable|string',
            'material_importance' => 'nullable|string|max:255',
            'administrative_action' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:255',
            'document_typology' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('documents', 'public');
            $validated['file_path'] = $filePath;
        }

        Document::create($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Document créé avec succès.');
    }

    /**
     * Display the specified document.
     */
    public function show(Document $document)
    {
        return view('documents.show', compact('document'));
    }

    /**
     * Show the form for editing the specified document.
     */
    public function edit(Document $document)
    {
        $documentTypes = DocumentType::all();
        return view('documents.edit', compact('document', 'documentTypes'));
    }

    /**
     * Update the specified document in storage.
     */
    public function update(Request $request, Document $document)
    {
        $validated = $request->validate([
            'reference' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'title_analysis' => 'nullable|string|max:255',
            'date' => 'required|date',
            'document_type_id' => 'required|exists:document_types,id',
            'description' => 'required|string',
            'content_presentation' => 'nullable|string',
            'material_importance' => 'nullable|string|max:255',
            'administrative_action' => 'nullable|string|max:255',
            'theme' => 'nullable|string|max:255',
            'document_typology' => 'nullable|string|max:255',
            'file' => 'nullable|file|max:10240', // 10MB max
        ]);

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($document->file_path) {
                Storage::disk('public')->delete($document->file_path);
            }
            
            $filePath = $request->file('file')->store('documents', 'public');
            $validated['file_path'] = $filePath;
        }

        $document->update($validated);

        return redirect()->route('documents.index')
            ->with('success', 'Document mis à jour avec succès.');
    }

    /**
     * Remove the specified document from storage.
     */
    public function destroy(Document $document)
    {
        if ($document->file_path) {
            Storage::disk('public')->delete($document->file_path);
        }
        
        $document->delete();

        return redirect()->route('documents.index')
            ->with('success', 'Document supprimé avec succès.');
    }

    /**
     * Download document file.
     *
     * @param  \App\Models\Document  $document
     * @return \Illuminate\Http\Response
     */
    public function download(Document $document)
    {
        if (!$document->file_path || !Storage::exists($document->file_path)) {
            return back()->with('error', 'Le fichier n\'existe pas.');
        }

        return Storage::download($document->file_path, basename($document->file_path));
    }

    /**
     * Export documents data as CSV.
     */
    public function export()
    {
        $fileName = 'documents_' . date('Y-m-d') . '.csv';
        $documents = Document::with('documentType')->get();

        $headers = [
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $columns = ['ID', 'Titre', 'Date', 'Type de document', 'Description', 'État matériel', 'Fichier', 'Créé le'];

        $callback = function () use ($documents, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($documents as $document) {
                $row['ID'] = $document->id;
                $row['Titre'] = $document->title;
                $row['Date'] = $document->date;
                $row['Type de document'] = $document->documentType->name;
                $row['Description'] = $document->description;
                $row['État matériel'] = $document->material_condition;
                $row['Fichier'] = $document->file_path ? 'Oui' : 'Non';
                $row['Créé le'] = $document->created_at;

                fputcsv($file, array_values($row));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export documents data as Excel.
     */
    public function exportExcel()
    {
        return Excel::download(new \App\Exports\DocumentsExport(), 'documents_' . date('Y-m-d') . '.xlsx');
    }

    /**
     * Import form
     */
    public function importForm()
    {
        return view('documents.import');
    }

    /**
     * Process the uploaded CSV or Excel file and show mapping form.
     */
    public function processImport(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt,xlsx,xls',
        ]);

        try {
            $file = $request->file('file');
            $path = $file->getRealPath();
            
            // Détecter le type de fichier
            $fileExtension = $file->getClientOriginalExtension();
            
            $data = [];
            $header = [];
            
            if (in_array($fileExtension, ['xlsx', 'xls'])) {
                // Traitement des fichiers Excel avec plus de vérifications
                try {
                    $spreadsheet = IOFactory::load($path);
                    $worksheet = $spreadsheet->getActiveSheet();
                    
                    $headerRow = null;
                    $rowIndex = 0;
                    
                    // Extraire les données ligne par ligne avec une meilleure gestion des erreurs
                    foreach ($worksheet->getRowIterator() as $row) {
                        $rowData = [];
                        $cellIterator = $row->getCellIterator();
                        $cellIterator->setIterateOnlyExistingCells(false);
                        
                        foreach ($cellIterator as $cell) {
                            // Garantir une conversion en chaîne sécurisée
                            $cellValue = $cell->getValue();
                            $safeValue = $this->ensureString($cellValue);
                            $rowData[] = $safeValue;
                        }
                        
                        if ($rowIndex === 0) {
                            $headerRow = $rowData;
                            $rowIndex++;
                        } else {
                            // Vérifier que la ligne n'est pas entièrement vide
                            $hasData = false;
                            foreach ($rowData as $cellValue) {
                                if (!empty(trim($cellValue))) {
                                    $hasData = true;
                                    break;
                                }
                            }
                            
                            if ($hasData) {
                                $data[] = $rowData;
                            }
                            $rowIndex++;
                        }
                    }
                    
                    $header = $headerRow;
                } catch (\Exception $e) {
                    // En cas d'erreur avec PhpSpreadsheet, essayer une méthode plus simple
                    return redirect()->route('documents.import.form')
                        ->with('error', 'Erreur lors de la lecture du fichier Excel : ' . $e->getMessage());
                }
            } else {
                // Traitement des fichiers CSV
                $csvData = array_map('str_getcsv', file($path));
                if (empty($csvData)) {
                    return redirect()->route('documents.import.form')
                        ->with('error', 'Le fichier CSV est vide.');
                }
                
                $header = array_shift($csvData);
                $header = array_map([$this, 'ensureString'], $header);
                
                foreach ($csvData as $row) {
                    // Vérifier que la ligne n'est pas entièrement vide
                    $hasData = false;
                    foreach ($row as $cellValue) {
                        if (!empty(trim($cellValue))) {
                            $hasData = true;
                            break;
                        }
                    }
                    
                    if ($hasData) {
                        $data[] = array_map([$this, 'ensureString'], $row);
                    }
                }
            }
            
            // Vérification des données
            if (empty($header) || empty($data)) {
                return redirect()->route('documents.import.form')
                    ->with('error', 'Le fichier ne contient pas de données valides.');
            }
            
            // Store safe data in session for the next step
            Session::put('import_data', $data);
            Session::put('import_header', $header);
            
            // Get all document types for dropdown
            $documentTypes = DocumentType::all();
            
            // Sample row for preview
            $sampleRow = !empty($data) ? $data[0] : [];
            
            return view('documents.import-mapping', compact('header', 'sampleRow', 'documentTypes'));
            
        } catch (\Exception $e) {
            return redirect()->route('documents.import.form')
                ->with('error', 'Une erreur est survenue lors de l\'importation : ' . $e->getMessage());
        }
    }
    
    /**
     * Garantit qu'une valeur est convertie en chaîne, même si c'est un tableau ou un objet.
     * 
     * @param mixed $value La valeur à convertir
     * @return string La valeur convertie en chaîne
     */
    private function ensureString($value)
    {
        if ($value === null) {
            return '';
        }
        
        if (is_array($value)) {
            return implode(', ', array_map(function($item) {
                return is_scalar($item) ? (string)$item : json_encode($item);
            }, $value));
        }
        
        if (is_object($value) && !method_exists($value, '__toString')) {
            if (method_exists($value, 'format')) {
                // Pour les objets DateTime et similaires
                return $value->format('Y-m-d');
            }
            return json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        
        // Force la conversion en chaîne
        return (string)$value;
    }

    /**
     * Import documents from CSV with custom mapping.
     */
    public function importDocuments(Request $request)
    {
        $request->validate([
            'reference_column' => 'nullable|integer',
            'title_column' => 'required|integer',
            'title_analysis_column' => 'nullable|integer',
            'date_column' => 'required|integer',
            'document_type_column' => 'required|integer',
            'document_typology_column' => 'nullable|integer',
            'description_column' => 'required|integer',
            'content_presentation_column' => 'nullable|integer',
            'material_condition_column' => 'nullable|integer',
            'material_importance_column' => 'nullable|integer',
            'administrative_action_column' => 'nullable|integer',
            'theme_column' => 'nullable|integer',
        ]);

        // Get data from session
        $data = Session::get('import_data', []);
        
        $importCount = 0;
        
        foreach ($data as $row) {
            // Check if row has enough columns
            $columnsToCheck = [];
            if ($request->reference_column !== null) $columnsToCheck[] = $request->reference_column;
            if ($request->title_column !== null) $columnsToCheck[] = $request->title_column;
            if ($request->title_analysis_column !== null) $columnsToCheck[] = $request->title_analysis_column;
            if ($request->date_column !== null) $columnsToCheck[] = $request->date_column;
            if ($request->document_type_column !== null) $columnsToCheck[] = $request->document_type_column;
            if ($request->document_typology_column !== null) $columnsToCheck[] = $request->document_typology_column;
            if ($request->description_column !== null) $columnsToCheck[] = $request->description_column;
            if ($request->content_presentation_column !== null) $columnsToCheck[] = $request->content_presentation_column;
            if ($request->material_condition_column !== null) $columnsToCheck[] = $request->material_condition_column;
            if ($request->material_importance_column !== null) $columnsToCheck[] = $request->material_importance_column;
            if ($request->administrative_action_column !== null) $columnsToCheck[] = $request->administrative_action_column;
            if ($request->theme_column !== null) $columnsToCheck[] = $request->theme_column;
            
            $maxColumn = !empty($columnsToCheck) ? max($columnsToCheck) : 0;
            
            if (count($row) <= $maxColumn) {
                continue; // Skip invalid rows
            }
            
            // S'assurer que les valeurs sont des chaînes
            $reference = ($request->reference_column !== null && isset($row[$request->reference_column])) 
                ? $this->ensureString($row[$request->reference_column]) 
                : '';
                
            $title = isset($row[$request->title_column]) 
                ? $this->ensureString($row[$request->title_column]) 
                : '';
                
            $titleAnalysis = ($request->title_analysis_column !== null && isset($row[$request->title_analysis_column])) 
                ? $this->ensureString($row[$request->title_analysis_column]) 
                : '';
                
            $dateValue = isset($row[$request->date_column]) 
                ? $this->ensureString($row[$request->date_column]) 
                : '';
                
            $documentTypeValue = isset($row[$request->document_type_column]) 
                ? $this->ensureString($row[$request->document_type_column]) 
                : '';
                
            $documentTypology = ($request->document_typology_column !== null && isset($row[$request->document_typology_column])) 
                ? $this->ensureString($row[$request->document_typology_column]) 
                : '';
                
            $description = isset($row[$request->description_column]) 
                ? $this->ensureString($row[$request->description_column]) 
                : '';
                
            $contentPresentation = ($request->content_presentation_column !== null && isset($row[$request->content_presentation_column])) 
                ? $this->ensureString($row[$request->content_presentation_column]) 
                : '';
            
            $materialCondition = ($request->material_condition_column !== null && isset($row[$request->material_condition_column])) 
                ? $this->ensureString($row[$request->material_condition_column]) 
                : '';
            
            $materialImportance = ($request->material_importance_column !== null && isset($row[$request->material_importance_column])) 
                ? $this->ensureString($row[$request->material_importance_column]) 
                : '';
            
            $administrativeAction = ($request->administrative_action_column !== null && isset($row[$request->administrative_action_column])) 
                ? $this->ensureString($row[$request->administrative_action_column]) 
                : '';
            
            $theme = ($request->theme_column !== null && isset($row[$request->theme_column])) 
                ? $this->ensureString($row[$request->theme_column]) 
                : '';
            
            // Vérifier que les valeurs requises ne sont pas vides
            if (empty($title) || empty($documentTypeValue) || empty($description)) {
                continue; // Skip rows with empty required values
            }
            
            $documentType = DocumentType::where('name', $documentTypeValue)->first();
            
            if (!$documentType) {
                // Create new document type if it doesn't exist
                $documentType = new DocumentType();
                $documentType->name = $documentTypeValue;
                $documentType->save();
            }
            
            // Handle different date formats
            $date = null;
            if (!empty($dateValue)) {
                try {
                    $date = date('Y-m-d', strtotime($dateValue));
                } catch (\Exception $e) {
                    $date = date('Y-m-d');
                }
            } else {
                $date = date('Y-m-d');
            }
            
            Document::create([
                'reference' => $reference ?: null,
                'title' => $title,
                'title_analysis' => $titleAnalysis ?: null,
                'date' => $date,
                'document_type_id' => $documentType->id,
                'document_typology' => $documentTypology ?: null,
                'description' => $description,
                'content_presentation' => $contentPresentation ?: null,
                'material_condition' => $materialCondition ?: null,
                'material_importance' => $materialImportance ?: null,
                'administrative_action' => $administrativeAction ?: null,
                'theme' => $theme ?: null,
            ]);
            
            $importCount++;
        }
        
        // Clear the session data
        Session::forget(['import_data', 'import_header']);

        return redirect()->route('documents.index')
            ->with('success', $importCount . ' ' . __('documents importés avec succès.'));
    }
} 