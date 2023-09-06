<?php

namespace Database\Seeders;

use App\Models\Session;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SessionSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Session::create([
            'board_id' => 1,
            'date' => Carbon::now()->subDays(5),
            'soak_time' => 70,
            'soak_temperature' => 100,
            'reflow_gradient' => 2,
            'reflow_peak_temp' => 183,
            'reflow_max_time' => 120,
            'ramp_up_gradient' => 5,
            'cooldown_gradient' => -6,
        ]);
        Session::create([
            'board_id' => 1,
            'date' => Carbon::now()->subDays(2),
            'soak_time' => 90,
            'soak_temperature' => 120,
            'reflow_gradient' => 4,
            'reflow_peak_temp' => 210,
            'reflow_max_time' => 150,
            'ramp_up_gradient' => 6,
            'cooldown_gradient' => -5,
        ]);
    }
}
