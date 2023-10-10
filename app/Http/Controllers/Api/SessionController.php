<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function store(Request $request, Board $requestBoard): JsonResponse
    {
        $validInput = $request->validate([
            'soak_temperature' => 'required|numeric',
            'soak_time' => 'required|numeric',
            'reflow_max_time' => 'nullable|numeric|gt:0',
            'reflow_peak_temp' => 'required|numeric',
        ]);
        $validInput['board_id'] = $requestBoard->id;
        $session = Session::create($validInput);

        return response()->json($session);
    }
}
