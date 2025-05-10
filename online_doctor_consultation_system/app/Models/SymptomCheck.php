<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Disease;

class SymptomCheck extends Model
{
    public function diseases()
{
    return $this->belongsToMany(
      \App\Models\Disease::class,
      'symptom_check_diseases'
    );
}
    public function patient()
    {
        return $this->belongsTo(\App\Models\Patient::class, 'patient_id');
    }



}
