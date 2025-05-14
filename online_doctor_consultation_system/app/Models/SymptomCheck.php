<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Disease;
use App\Models\Patient;

class SymptomCheck extends Model
{
    protected $fillable = [
        'patient_id',
        'symptoms_text',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function diseases()
    {
        return $this->belongsToMany(
            Disease::class,
            'symptom_check_diseases',
            'symptom_check_id',
            'disease_id'
        );
    }
}


