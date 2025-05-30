<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\Doctor;
use App\Models\zoomMeeting;


class Appointment extends Model
{

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'scheduled_datetime',
        'mode',
        'status',
        'fee',

    ];

    // Add this:
    protected $casts = [
        'scheduled_datetime' => 'datetime',
    ];
    public function doctor()
{
    return $this->belongsTo(\App\Models\Doctor::class);
}
public function zoomMeeting()
{
    return $this->hasOne(\App\Models\ZoomMeeting::class);
}
public function patient() { return $this->belongsTo(Patient::class);  }
public function order()
{
    return $this->hasOne(App\Models\Order::class);
}


}
