<?php

// app/Models/ConsultationRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'description', 'date_start', 'date_end', 'status', 'user_id', 'priority_id',  'created_by', 'updated_by'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function priority()
    {
        return $this->belongsTo(Priority::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
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
    public function userType()
    {
        return $this->belongsTo(UserType::class, 'user_types_id');
    }
}
