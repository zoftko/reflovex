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
        $recentBoards = $recentBoards->map(function ($board) {
            return ['name' => $board->name, 'uuid' => $board->uuid, 'ip' => $board->ip, 'last_seen' => $board->last_seen];
        });

        $statistics = collect();

        //Max temperature registered
        $maxTempReg = Measurement::max('temperature');
        $statistics->put('Max.Temp.Reg.', ['data' => $maxTempReg.' °C', 'class' => 'afterMaxTemp']);

        //Largest session
        $allMeasurements = Measurement::get()->groupBy('session_id');
        $max = 0;
        $sessionKey = null;
        foreach ($allMeasurements as $sk => $m) {
            $current = $m->count();
            if ($current > $max) {
                $sessionKey = $sk;
                $max = $current;
            }
        }
        $statistics->put('Longest Session', ['data' => CarbonInterval::seconds($max)->cascade()->forHumans(), 'class' => 'afterLongSession']);

        //Max temperature of the day
        $maxTempToday = Measurement::whereDay('created_at', (string) (now()->day))->max('temperature');
        $maxTempToday = $maxTempToday != null ? $maxTempToday.' °C' : 'N/A';
        $statistics->put('Max.Temp.Today', ['data' => $maxTempToday, 'class' => 'afterTodayTemp']);

        //Board with most sessions
        $sessions = Session::with('board')->orderBy('id', 'desc')->get()->groupBy('board_id');
        $boardMostSessions = null;
        $boardSessionCount = 0;
        foreach ($sessions as $boardId => $s) {
            $count = $s->count();
            if ($count > $boardSessionCount) {
                $boardSessionCount = $count;
                $boardMostSessions = $s[0]->board ?? null;
            }
        }
        $boardName = $boardMostSessions->name ?? 'N/A';
        $statistics->put('Most sessions', ['data' => $boardName.' ('.$boardSessionCount.')', 'class' => 'afterMostSessions']);

        return view('dashboard', [
            'session' => $session,
            'xAxis' => $xAxis,
            'yAxis' => $yAxis,
            'recentBoards' => $recentBoards,
            'statistics' => $statistics,
            'boardsCount' => $this->boardService->boardsCount(),
            'profilesCount' => $this->profileService->profilesCount(),
            'sessionsCount' => $this->sessionService->sessionsCount(),
            'sessionTime' => CarbonInterval::seconds(count($yAxis))->cascade()->forHumans(),
        ]);
    }
}
