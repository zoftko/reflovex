<?php

namespace Database\Seeders;

use App\Models\Measurement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $temp = 20;
        $gradient = 2;
        //Make ramp to soak
        for ($i = 1; $i <= 40; $i++) {
            Measurement::create([
                'session_id' => 1,
                'temperature' => $temp,
                'sequence' => $i,
            ]);
            $temp += $gradient;
        }
        //Now we make soak time
        for ($i = 41; $i <= 140; $i++) {
            Measurement::create([
                'session_id' => 1,
                'temperature' => $temp,
                'sequence' => $i,
            ]);
        }
        $gradient = 5; //ramp up gradient to peak
        for ($i = 141; $i < 158; $i++) {
            Measurement::create([
                'session_id' => 1,
                'temperature' => $temp,
                'sequence' => $i,
            ]);
            $temp += $gradient;
        }
        //Cool down ramp
        $gradient = -6;
        for ($i = 158; $i <= 185; $i++) {
            Measurement::create([
                'session_id' => 1,
                'temperature' => $temp,
                'sequence' => $i,
            ]);
            $temp += $gradient;
        }
    }
}
