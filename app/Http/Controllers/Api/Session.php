<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BoardService;
use App\Services\SessionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Session extends Controller
{
    protected BoardService $boardService;
    protected SessionService $sessionService;
    public function __construct()
    {
        $this->boardService = new BoardService();
        $this->sessionService = new SessionService();
    }

    public function store(Request $request): JsonResponse
    {
        $validInput = $request->validate([
            'uuid' => 'required|string|size:12',
            'soak_temperature' => 'required|numeric',
            'soak_time' => 'required|numeric',
            'reflow_gradient' => 'required|numeric',
            'ramp_up_gradient' => 'required|numeric',
            'reflow_max_time' => 'required|numeric',
            'cooldown_gradient' => 'required|numeric',
            'reflow_peak_temp' => 'required|numeric'
        ]);

        $board = $this->boardService->boardByUUID($validInput['uuid']);
        if($board){
            $validInput['board_id'] = $board->id;
            $validInput['date'] = now();

            $session = $this->sessionService->createSession($validInput);
            if($session->count() > 0)
                return response()->json($session);
        }

        return response()->json([
            'message' => 'Session not created',
        ], 500);
    }
}
