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
   public function payments()
    {
        return $this->hasManyThrough(
            Payment::class,      // Final model
            Appointment::class,  // Intermediate
            'patient_id',        // FK on appointments
            'appointment_id',    // FK on payments
            'id',                // Local key on patients
            'id'                 // Local key on appointments
        );
    }

}
