<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();


        $this->call([

            RolesTableSeeder::class,
                UsersTableSeeder::class,
                   DoctorsTableSeeder::class,
                   PatientsTableSeeder::class,
                   AppointmentsTableSeeder::class,
                   PaymentsTableSeeder::class,
                   ZoomMeetingsTableSeeder::class,
                   DiseasesTableSeeder::class,
                   SymptomChecksTableSeeder::class,
                   SymptomCheckDiseasesTableSeeder::class
        ]);
    }
}
