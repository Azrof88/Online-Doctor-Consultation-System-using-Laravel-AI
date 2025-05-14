<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Appointment;

class ZoomMeeting extends Model
{
    protected $fillable = [
        'appointment_id',
        'meeting_id',
        'meeting_password',
        'start_url',
        'join_url',
    ];

    /**
     * A ZoomMeeting belongs to one appointment.
     */
    public function appointment()
    {
        return $this->belongsTo(App\Models\Appointment::class);
    }
}
