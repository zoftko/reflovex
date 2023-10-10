<?php

namespace App\Http\Controllers;

use App\Models\Board;
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

        //Get last 4 boards with recent activity
        $recentBoards = Board::orderBy('last_seen', 'desc')->limit(4)->get();
        $recentBoards = $recentBoards->map(function($board){
           return ['name' => $board->name, 'uuid' => $board->uuid, 'ip' => $board->ip, 'last_seen' => $board->last_seen];
        });

        return view('dashboard', [
            'session' => $session,
            'xAxis' => $xAxis,
            'yAxis' => $yAxis,
            'recentBoards' => $recentBoards,
            'boardsCount' => $this->boardService->boardsCount(),
            'profilesCount' => $this->profileService->profilesCount(),
            'sessionsCount' => $this->sessionService->sessionsCount(),
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
