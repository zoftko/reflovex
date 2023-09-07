<?php

namespace App\Http\Controllers;

use App\Services\SessionService;
use Carbon\CarbonInterval;

class Dashboard extends Controller
{
    private SessionService $sessionService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
    }

    //Method to show dashboard and send necessary information
    public function dashboard()
    {
        $session = $this->sessionService->lastSession();

        //Extract data for X and Y Axis
        if(!empty($session)){
            $xAxis = $session->measurements->map(function ($measurement){
                return $measurement->sequence;
            });
            $yAxis = $session->measurements->map(function ($measurement){
                return $measurement->temperature;
            });
        }
        //Calculate session time

        return view('dashboard', [
            'session' => $session,
            'xAxis' => $xAxis,
            'yAxis' => $yAxis,
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans()
        ]);
    }
}
