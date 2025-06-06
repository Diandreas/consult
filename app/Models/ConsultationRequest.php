<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'description',
        'date_start',
        'date_end',
        'status',
        'user_id',
        'priority_id',
        'created_by',
        'updated_by',
        'document_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function consultationAnswers()
    {
        return $this->hasMany(ConsultationAnswer::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function userFiles()
    {
        return $this->hasMany(UserFile::class, 'user_id', 'user_id');
    }

    // Remove this if you don't need the category relationship,
    // or uncomment the related lines in your migration if you want to use it.
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_types_id');
    }

    /**
     * Obtenir le document associé à la requête de consultation.
     */
    public function document()
    {
        return $this->belongsTo(Document::class);
    }
}
