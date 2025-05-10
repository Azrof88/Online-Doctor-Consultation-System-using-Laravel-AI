<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // 1 Admin
         User::create([
            'name'     => 'Alice Admin',
            'email'    => 'alice@admin.com',
            'password' => Hash::make('password'),
            'role'  => 1,
            'mobile' => '1234567890'
        ]);

        // 2 Doctors
        User::create([ 'name'=>'Dr. John Doe','email'=>'john@doctor.com','password'=>Hash::make('password'),'role'=>2,'mobile'=>'1234567890' ]);
        User::create([ 'name'=>'Dr. Jane Roe','email'=>'jane@doctor.com','password'=>Hash::make('password'),'role'=>2,'mobile'=>'0987654321' ]);

        // 3 Patients
        User::create([ 'name'=>'Patient One','email'=>'p1@patient.com','password'=>Hash::make('password'),'role'=>3,'mobile'=>'1234567890' ]);
        User::create([ 'name'=>'Patient Two','email'=>'p2@patient.com','password'=>Hash::make('password'),'role'=>3,   'mobile'=>'0987654321' ]);
    }
}
