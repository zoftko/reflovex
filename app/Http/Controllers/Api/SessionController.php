<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $validInput = $request->validate([
            'soak_temperature' => 'required|numeric',
            'soak_time' => 'required|numeric',
            'reflow_gradient' => 'required|numeric',
            'ramp_up_gradient' => 'required|numeric',
            'reflow_max_time' => 'required|numeric',
            'cooldown_gradient' => 'required|numeric',
            'reflow_peak_temp' => 'required|numeric',
        ]);
        $validInput['board_id'] = $request->board->id;
        $session = Session::create($validInput);

        return response()->json($session);
    }
}
