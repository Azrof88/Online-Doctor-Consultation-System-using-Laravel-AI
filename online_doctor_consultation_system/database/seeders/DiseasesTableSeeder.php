<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Disease;

class DiseasesTableSeeder extends Seeder
{
    public function run()
    {
        collect(['Flu','Cold','Migraine'])->each(function($d) {
            Disease::create(['name'=>$d,'description'=>"Description of $d"]);
        });
    }
}
