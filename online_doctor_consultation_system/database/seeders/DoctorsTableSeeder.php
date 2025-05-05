<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class DoctorsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        // find the doctor user we just created
        $docUser = User::where('email','fahimaakter5787@gmail.com')->first();

        DB::table('doctors')->insert([
            'user_id'               => $docUser->id,
            'specialization'        => 'Cardiology',
            'bio'                   => '10+ years experience in heart health.',
            'availability_schedule' => 'Mon–Fri, 9am–5pm',
            'created_at'            => $now,
            'updated_at'            => $now,
        ]);
    }
}
