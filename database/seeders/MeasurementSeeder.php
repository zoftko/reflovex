<?php

namespace Database\Seeders;

use App\Models\Measurement;
use App\Models\Session;
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
        foreach (Session::where('id', '>', '0')->limit(5)->get() as $session) {
            $temp = 20;
            $sequence = 1;

            //Make ramp to soak
            while ($temp < $session->soak_temperature) {
                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => $sequence++,
                ]);
                $temp += $session->ramp_up_gradient;
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
                $temp += $session->reflow_gradient;
            }

            //Cool down ramp
            while ($temp > 50) {
                Measurement::create([
                    'session_id' => $session->id,
                    'temperature' => $temp,
                    'sequence' => ++$sequence,
                ]);
                $temp -= $session->cooldown_gradient;
            }
        }
    }
}
