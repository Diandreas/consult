<?php
// app/Models/Priority.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Priority extends Model
{
    use HasFactory;
    protected $table="priority";
    protected $fillable = ['name', 'created_by', 'updated_by'];

    public function consultationRequests()
    {
        return $this->hasMany(ConsultationRequest::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
