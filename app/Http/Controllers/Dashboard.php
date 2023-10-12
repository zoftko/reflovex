<?php

namespace App\Http\Controllers;

use App\Models\Board;
use App\Models\Measurement;
use App\Models\Session;
use App\Services\BoardService;
use App\Services\ProfileService;
use App\Services\SessionService;
use Carbon\CarbonInterval;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;

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

    private function statistics():Collection
    {
        $statistics = collect();

        //Max temperature registered
        $maxTempReg = Measurement::max('temperature');
        $statistics->put('Max.Temp.Reg.', $maxTempReg.' °C');

        //Largest session
        $allMeasurements = Measurement::get()->groupBy('session_id');
        $max = 0;
        $sessionKey = null;
        foreach ($allMeasurements as $session => $m){
            $current = $m->count();
            if($current > $max){
                $sessionKey = $session;
                $max = $current;
            }
        }
        $statistics->put("Longest Session", "S.ID: {$sessionKey}, ".CarbonInterval::seconds($max)->cascade()->forHumans());

        //Max temperature of the day
        $maxTempToday = Measurement::whereDay('created_at', (now()->day))->max('temperature');
        $maxTempToday = $maxTempToday != null ? $maxTempToday.' °C' : 'N/A';
        $statistics->put('Max.Temp.Today', $maxTempToday);

        //Board with most sessions
        $sessions = Session::with('board')->orderBy('id', 'desc')->get()->groupBy('board_id');
        $boardMostSessions = null;
        $boardSessionCount = 0;
        foreach ($sessions as $boardId => $s){
            $count = $s->count();
            if($count > $boardSessionCount){
                $boardSessionCount = $count;
                $boardMostSessions = $s[0]->board;
            }
        }
        $statistics->put('Board most sessions', $boardMostSessions->name.' with '.$boardSessionCount.' sessions');

        return $statistics;
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
            'statistics' => $this->statistics(),
            'boardsCount' => $this->boardService->boardsCount(),
            'profilesCount' => $this->profileService->profilesCount(),
            'sessionsCount' => $this->sessionService->sessionsCount(),
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
