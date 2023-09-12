<?php

namespace App\Http\Controllers;

use App\Services\BoardService;
use App\Services\ProfileService;
use App\Services\SessionService;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;

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

    public function dashboard(): View
    {
        $session = $this->sessionService->lastSession();

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
            'boardsCount' => $this->boardService->boardsCount(),
            'profilesCount' => $this->profileService->profilesCount(),
            'sessionsCount' => $this->sessionService->sessionsCount(),
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
