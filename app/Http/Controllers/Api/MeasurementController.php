<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Board;
use App\Models\Measurement;
use App\Models\Session;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MeasurementController extends Controller
{
    public function store(Request $request, Board $requestBoard): JsonResponse
    {
        $validData = $request->validate([
            'session_id' => 'nullable|numeric|exists:sessions,id',
            'measurements' => 'required|array',
        ]);

        if (! array_key_exists('session_id', $validData)) {
            // ORDER BY id DESC is used to prevent clashes during unit testing (inserting during the same second)
            $session = Session::whereBoardId($requestBoard->id)->latest()->orderBy('id', 'DESC')->first();
            if ($session == null) {
                return response()->json(['error' => 'No session was specified, and no sessions exists for the board'], 400);
            }
            $session_id = $session->id;
        } else {
            $session_id = $validData['session_id'];
        }

        foreach ($validData['measurements'] as $m) {
            Measurement::create([
                'session_id' => $session_id,
                'temperature' => $m['temp'],
                'sequence' => $m['sequence'],
            ]);
        }

        return response()->json([], 201);
    }
}
