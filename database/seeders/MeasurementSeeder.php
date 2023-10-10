<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Models\Session;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MeasurementSeeder extends Seeder
{
    use WithoutModelEvents;

    private function randomFloat(float $min, float $max)
    {
        return rand($min * 100, $max * 100) / 100;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Session::get() as $session) {
            $temp = 20;
            $sequence = 1;

            //Make ramp to soak
            while ($temp < $session->soak_temperature) {
                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => $sequence++,
                ]);
                $temp += $this->randomFloat(0.5, 2.5);
            }

            //Now we make soak time
            for ($seconds = 0; $seconds <= $session->soak_time; $seconds++, $sequence++) {
                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => $sequence,
                ]);
            }

            // Ramp up gradient to peak
            while ($temp < $session->reflow_peak_temp) {

                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => ++$sequence,
                ]);
                $temp += $this->randomFloat(1, 2.5);
            }

            //Cool down ramp
            while ($temp > 50) {
                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => ++$sequence,
                ]);
                $temp -= $this->randomFloat(2, 4);
            }
        }
    }
}
