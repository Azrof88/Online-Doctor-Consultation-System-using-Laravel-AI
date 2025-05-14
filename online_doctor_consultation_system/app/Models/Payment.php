<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // 1) Which columns you allow to be filled via create()/fill()
    protected $fillable = [
        'appointment_id',
              // remove this line if you kept the hasManyThrough approach
        'amount',
        'method',
        'status',
        'transaction_id',
    ];

    // 2) If you added a patient_id FK on payments() – optional
    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    // 3) Every payment belongs to an appointment
    public function appointment()
    {
        return $this->belongsTo(\App\Models\Appointment::class);
    }
}
