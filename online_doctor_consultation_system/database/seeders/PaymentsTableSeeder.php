<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Payment;
use App\Models\Appointment;

class PaymentsTableSeeder extends Seeder
{
    public function run()
    {
        $appt = Appointment::where('mode','online')->first();
        if($appt) {
            Payment::create([
                'appointment_id'=>$appt->id,
                'amount'=>100.00,
                'method'=>'card',
                'status'=>'paid',
                'transaction_id'=> 'TXN'.time(),
            ]);
        }
    }
}
