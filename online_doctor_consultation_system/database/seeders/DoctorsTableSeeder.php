<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use App\Models\User;
use App\Models\Doctor;
class DoctorsTableSeeder extends Seeder
{
    public function run()
    {
        $docUsers = User::where('role',2)->get();
        collect([
            ['specialization'=>'Cardiology','bio'=>'Heart specialist.','availability_schedule'=>'Mon-Fri 9-5','fee'=>200],
            ['specialization'=>'Orthopedics','bio'=>'Bone specialist.','availability_schedule'=>'Tue-Thu 10-4','fee'=>250],
        ])->each(function($data,$i) use($docUsers) {
            Doctor::create(array_merge([
                'user_id'=>$docUsers[$i]->id
            ], $data));
        });
    }
}
