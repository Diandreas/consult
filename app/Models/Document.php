<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Document extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'reference',
        'title',
        'title_analysis',
        'date',
        'document_type_id',
        'description',
        'content_presentation',
        'material_condition',
        'material_importance',
        'administrative_action',
        'theme',
        'document_typology',
        'file_path',
    ];

    /**
     * Get the document type that owns the document.
     */
    public function documentType(): BelongsTo
    {
        return $this->belongsTo(DocumentType::class);
    }
} 