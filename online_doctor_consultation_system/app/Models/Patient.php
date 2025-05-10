<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class, 'patient_id');
    }
    public function symptomChecks()
    {
        return $this->hasMany(SymptomCheck::class, 'patient_id');
    }

}
