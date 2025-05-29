<?php

namespace App\Exports;

use App\Models\Document;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class DocumentsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Document::with('documentType')->get();
    }

    /**
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Référence',
            'Titre',
            'Intitulé/analyse',
            'Date',
            'Type de document',
            'Typologie documentaire',
            'Description',
            'Présentation du contenu',
            'État matériel',
            'Importance matérielle',
            'Action administrative',
            'Thématique',
            'Fichier disponible',
            'Créé le'
        ];
    }

    /**
     * @param mixed $document
     * @return array
     */
    public function map($document): array
    {
        return [
            $document->id,
            $document->reference,
            $document->title,
            $document->title_analysis,
            $document->date,
            $document->documentType->name,
            $document->document_typology,
            $document->description,
            $document->content_presentation,
            $document->material_condition,
            $document->material_importance,
            $document->administrative_action,
            $document->theme,
            $document->file_path ? 'Oui' : 'Non',
            $document->created_at->format('d/m/Y H:i:s')
        ];
    }
} 