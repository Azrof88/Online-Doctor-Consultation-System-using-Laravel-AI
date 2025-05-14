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
        // Grab *all* online appointments
        Appointment::where('mode', 'online')->get()->each(function($appt) {
            // Make sure the doctor actually has a link set
            $docLink = $appt->doctor->zoom_link;
            if (! $docLink) {
                // Skip if no link on the doctor
                return;
            }

            // Create or update the ZoomMeeting record
            ZoomMeeting::updateOrCreate(
                ['appointment_id' => $appt->id],
                [
                    'meeting_id'       => '123-456-789',      // or generate if you like
                    'meeting_password' => 'pass123',          // likewise
                    'start_url'        => 'https://zoom.us/start/123',
                    'join_url'         => $docLink,           // ← use the doctor’s own link
                ]
            );
        });
    }
}
