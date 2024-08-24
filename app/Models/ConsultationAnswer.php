<?php

// app/Models/ConsultationAnswer.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'consultation_request_id', 'created_by','updated_by'];

    public function consultationRequest()
    {
        return $this->belongsTo(ConsultationRequest::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
