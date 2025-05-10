<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SymptomCheck;
use App\Models\Disease;

class SymptomCheckDiseasesTableSeeder extends Seeder
{
    public function run()
    {
        $check   = SymptomCheck::first();
        $disease = Disease::where('name','Flu')->first();
        if($check && $disease) {
            $check->diseases()->attach($disease->id);
        }
    }
}
