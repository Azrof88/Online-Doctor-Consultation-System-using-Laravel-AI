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
            ['specialization'=>'Cardiology','bio'=>'Heart specialist.','availability_schedule'=>'Mon-Fri 9-5','fee'=>200,'name'=>'Dr. John Doe','zoom_link'=>'https://us04web.zoom.us/j/2792592338?pwd=R295ajd4clh4VmZJL3hiQ3pScXE3Zz09',],
            ['specialization'=>'Orthopedics','bio'=>'Bone specialist.','availability_schedule'=>'Tue-Thu 10-4','fee'=>250,'name'=>'Dr. Jane Roe','zoom_link'=>'https://us04web.zoom.us/j/2792592338?pwd=R295ajd4clh4VmZJL3hiQ3pScXE3Zz09',],
        ])->each(function($data,$i) use($docUsers) {
            Doctor::create(array_merge([
                'user_id'=>$docUsers[$i]->id
            ], $data));
        });
    }
}
