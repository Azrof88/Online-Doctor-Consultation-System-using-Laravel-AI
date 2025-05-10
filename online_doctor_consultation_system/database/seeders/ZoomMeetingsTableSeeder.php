<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ZoomMeeting;
use App\Models\Appointment;

class ZoomMeetingsTableSeeder extends Seeder
{
    public function run()
    {
        $appt = Appointment::where('mode','online')->first();
        if($appt) {
            ZoomMeeting::create([
                'appointment_id'=>$appt->id,
                'meeting_id'=>'123-456-789',
                'meeting_password'=>'pass123',
                'start_url'=>'https://zoom.us/start/123',
                'join_url'=>'https://zoom.us/join/123',
            ]);
        }
    }
}
