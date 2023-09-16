<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\MeasurementService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class Measurement extends Controller
{
    private MeasurementService $measurementService;

    public function __construct()
    {
        $this->measurementService = new MeasurementService();
    }

    public function store(Request $request): JsonResponse
    {
        $validData = $request->validate([
            'session_id' => 'required|numeric|exists:sessions,id',
            'measurements' => 'required|array',
        ]);

        $data = [];
        foreach ($validData['measurements'] as $m) {
            $data[] = [
                'session_id' => $validData['session_id'],
                'temperature' => $m['temp'],
                'sequence' => $m['sequence'],
            ];
        }

        $rows = $this->measurementService->createMeasurements($data);

        return response()->json([
            'status' => 'ok',
            'last_sequence' => $rows['last_sequence'],
            'inserted_rows' => $rows['inserted'],
        ]);
    }
}
