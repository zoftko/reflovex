<?php

use App\Models\Board;
use App\Models\Measurement;
use App\Models\Session;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Helper\ProgressBar;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

/*
 * @var Illuminate\Support\Facades\Artisan $this
 */
Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

function addMeasurement(Collection &$measurements, int $sessionID, float $temp, int $sequence): void
{
    $measurements->push([
        'session_id' => $sessionID,
        'temperature' => $temp,
        'sequence' => $sequence,
    ]);
}

function saveMeasurements(Collection &$measurements, int $sleepTime, ProgressBar &$progress): void
{
    if ($measurements->count() == 10) {
        $measurements->map(function ($measurement) {
            Measurement::create($measurement);
        });
        $measurements = collect();
        $progress->advance(10);
        sleep($sleepTime);
    }
}
/*
 * @var Illuminate\Support\Facades\Artisan $this
 * @var App\Models\Board $board
 */
Artisan::command('reflow {soakTemperature} {soakTime} {reflowPeakTemp} {sleepTime?} {reflowMaxTime?}', function ($soakTemperature, $soakTime, $reflowPeakTemp, $sleepTime = 10, $reflowMaxTime = 80) {
    $board = Board::inRandomOrder()->limit(1)->first();

    $progress = $this->getOutput()->createProgressBar($soakTime + $reflowPeakTemp + $soakTemperature);
    $progress->setFormat("%message%\n %current%/%max% [%bar%] %percent:3s%%\n");
    $progress->setMessage("Creating session on board {$board->name}");
    $progress->start();

    $session = Session::create([
        'board_id' => $board->id,
        'soak_time' => $soakTime,
        'soak_temperature' => $soakTemperature,
        'reflow_peak_temp' => $reflowPeakTemp,
        'reflow_max_time' => $reflowMaxTime,
    ]);

    $temp = 20;
    $measurements = collect();
    $sequence = 1;

    //Make ramp to soak
    $progress->setMessage('Starting raising to soak temperature...');
    while ($temp < $soakTemperature) {
        addMeasurement($measurements, $session->id, $temp, $sequence++);
        saveMeasurements($measurements, $sleepTime, $progress);
        $temp += mt_rand(5, 25) / 10;
    }

    //Now we make soak time
    $progress->setMessage('Keep on soak time...');
    for ($seconds = 0; $seconds <= $soakTime; $seconds++, $sequence++) {
        addMeasurement($measurements, $session->id, $temp, $sequence);
        saveMeasurements($measurements, $sleepTime, $progress);
    }

    // Ramp up gradient to peak
    $progress->setMessage('Ramp up to reflow peak temperature...');
    while ($temp < $reflowPeakTemp) {
        addMeasurement($measurements, $session->id, $temp, $sequence++);
        saveMeasurements($measurements, $sleepTime, $progress);
        $temp += mt_rand(10, 25) / 10;
    }

    //Cool down ramp
    $progress->setMessage('Cooling down...');
    while ($temp > 50) {
        addMeasurement($measurements, $session->id, $temp, $sequence++);
        saveMeasurements($measurements, $sleepTime, $progress);
        $temp -= mt_rand(20, 40) / 10;
    }
    $progress->finish();
})->purpose('Simulate reflow session');
