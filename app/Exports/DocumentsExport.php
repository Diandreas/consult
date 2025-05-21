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
            'Titre',
            'Date',
            'Type de document',
            'Description',
            'État matériel',
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
            $document->title,
            $document->date,
            $document->documentType->name,
            $document->description,
            $document->material_condition,
            $document->file_path ? 'Oui' : 'Non',
            $document->created_at->format('d/m/Y H:i:s')
        ];
    }
} 