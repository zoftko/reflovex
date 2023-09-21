<?php

namespace App\Services;

use App\Models\Measurement;

class MeasurementService
{
    /**
     * Method to insert a chunk of measurements
     *
     * @return array<string, int|null>
     */
    public function createMeasurements(array $measurements): array // @phpstan-ignore-line
    {
        $rows = 0;
        $last_sequence = null;
        foreach ($measurements as $m) {
            $insert = Measurement::create($m);
            $rows++;
            $last_sequence = $insert->sequence;
        }

        return ['inserted' => $rows, 'last_sequence' => $last_sequence];
    }
}
