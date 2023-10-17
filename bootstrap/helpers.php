<?php
/*
 * Next helper are designed due to on route/console.php looks like we can not declare functions
 * that not belongs to Artisan class. So, these definitions are used for Artisan reflow command
 * rc at the beginning of the function names means reflow command
 */

use App\Models\Measurement;
use Illuminate\Support\Collection;
use Symfony\Component\Console\Helper\ProgressBar;

if (! function_exists('rcAddMeasurement')) {
    function rcAddMeasurement(Collection &$measurements, int $sessionID, float $temp, int $sequence): void
    {
        $measurements->push([
            'session_id' => $sessionID,
            'temperature' => $temp,
            'sequence' => $sequence,
        ]);
    }
}

if (! function_exists('rcSaveMeasurements')) {
    function rcSaveMeasurements(Collection &$measurements, int $sleepTime, ProgressBar &$progress): void
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
}
