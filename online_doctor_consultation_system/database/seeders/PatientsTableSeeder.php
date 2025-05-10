<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\Patient;
use App\Models\User;

class PatientsTableSeeder extends Seeder
{
    public function run()
    {
        $patUsers = User::where('role',3)->get();
        collect([
            ['age'=>30,'gender'=>'male','contact_number'=>'1234567890'],
            ['age'=>28,'gender'=>'female','contact_number'=>'0987654321'],
        ])->each(function($data,$i) use($patUsers) {
            Patient::create(array_merge([
                'user_id'=>$patUsers[$i]->id
            ], $data));
        });
    }
}
