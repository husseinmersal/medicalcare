<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Doctor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $doctors =  Doctor::factory()->count(10)->create();

       foreach($doctors as $doctor){
        $Appointments = Appointment::all()->random()->id;
        $doctor->appointments()->attach($Appointments);
       }
    }
}
