<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $now = Carbon::now();
        $patUser = User::where('email','azrof2107088@stud.kuet.ac.bd')->first();

        DB::table('patients')->insert([
            'user_id'        => $patUser->id,
            'age'            => 30,
            'gender'         => 'male',
            'contact_number' => '2222222222',
            'created_at'     => $now,
            'updated_at'     => $now,
        ]);
    }
}
