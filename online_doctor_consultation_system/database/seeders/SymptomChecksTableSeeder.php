<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\SymptomCheck;
use App\Models\Patient;

class SymptomChecksTableSeeder extends Seeder
{
    public function run()
    {
        $patients = Patient::all();
        SymptomCheck::create([
            'patient_id'=>$patients[0]->id,
            'symptoms_text'=>'Fever, cough, headache',
        ]);
    }
}
