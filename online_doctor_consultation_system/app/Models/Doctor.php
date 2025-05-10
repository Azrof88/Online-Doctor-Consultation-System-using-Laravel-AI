<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Doctor extends Model
{

    protected $fillable = [
        'id',
        'user_id',
        'specialization',
        'fee',

        'bio',

    ];

    public function user()
{
    return $this->belongsTo(\App\Models\User::class, 'user_id');
}
public function appointments()
    {
        return $this->hasMany(Appointment::class, 'doctor_id');
    }
}
