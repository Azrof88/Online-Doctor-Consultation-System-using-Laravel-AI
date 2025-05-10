<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Appointment;
use App\Models\Doctor;
use App\Models\Patient;
use Carbon\Carbon;

class AppointmentsTableSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        $doctors  = Doctor::all();

        // One online, one offline
        Appointment::create([
            'patient_id'=> $patients[0]->id,
            'doctor_id' => $doctors[0]->id,
            //doctor fee column


            'scheduled_datetime'=>Carbon::now()->addDays(1),
            'mode'=>'online',
            'status'=>'confirmed',
        ]);

        Appointment::create([
            'patient_id'=> $patients[1]->id,
            'doctor_id' => $doctors[1]->id,
            //doctor fee column

            'scheduled_datetime'=>Carbon::now()->addDays(2),
            'mode'=>'offline',
            'status'=>'pending',
        ]);
    }
}
