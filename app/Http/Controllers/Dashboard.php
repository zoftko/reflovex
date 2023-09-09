<?php

namespace App\Http\Controllers;

use App\Services\BoardService;
use App\Services\ProfileService;
use App\Services\SessionService;
use Carbon\CarbonInterval;

class Dashboard extends Controller
{
    private SessionService $sessionService;

    private BoardService $boardService;

    private ProfileService $profileService;

    public function __construct()
    {
        $this->sessionService = new SessionService();
        $this->boardService = new BoardService();
        $this->profileService = new ProfileService();
    }

    //Method to show dashboard and send necessary information
    public function dashboard()
    {
        $session = $this->sessionService->lastSession();

        //Extract data for X and Y Axis
        if (! empty($session)) {
            $xAxis = $session->measurements->map(function ($measurement) {
                return $measurement->sequence;
            });
            $yAxis = $session->measurements->map(function ($measurement) {
                return $measurement->temperature;
            });
        }
        //Calculate session time

        return view('dashboard', [
            'session' => $session,
            'xAxis' => $xAxis,
            'yAxis' => $yAxis,
            'boardsCount' => $this->boardService->boardsCount(),
            'profilesCount' => $this->profileService->profilesCount(),
            'sessionsCount' => $this->sessionService->sessionsCount(),
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
