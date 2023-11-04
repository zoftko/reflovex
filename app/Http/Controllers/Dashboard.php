<?php

namespace App\Http\Controllers;

use App\Models\Session;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;

class Dashboard extends Controller
{
    public function dashboard(): View
    {
        $session = Session::latest()->with('measurements')->first();

        if (! empty($session)) {
            $xAxis = $session->measurements->map(function ($measurement) {
                return $measurement->sequence;
            });
            $yAxis = $session->measurements->map(function ($measurement) {
                return $measurement->temperature;
            });
        }
        $xAxis = $xAxis ?? [];
        $yAxis = $yAxis ?? [];

        return view('dashboard', [
            'session' => $session,
            'xAxis' => $xAxis,
            'yAxis' => $yAxis,
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
