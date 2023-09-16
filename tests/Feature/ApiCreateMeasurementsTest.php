<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Session;
use Tests\TestCase;

class ApiCreateMeasurementsTest extends TestCase
{
    protected Session $session;

    protected Board $board;

    protected function setUp(): void
    {
        parent::setUp();
        $this->board = Board::factory()->create();
        $this->session = Session::create([
            'board_id' => $this->board->id,
            'date' => now(),
            'soak_temperature' => 100,
            'soak_time' => 70,
            'reflow_gradient' => 2,
            'ramp_up_gradient' => 5,
            'reflow_peak_temp' => 183,
            'reflow_max_time' => 120,
            'cooldown_gradient' => -6,
        ]);
    }

    public function test_session_id_not_numeric(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'session_id' => '0',
            'measurements' => [],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_session_id_not_exists(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'session_id' => 0,
            'measurements' => [],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_missing_parameters(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'other_input' => 'other',
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_measurements_different_than_array(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'session_id' => 0,
            'measurements' => 179,
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_measurements_create_records(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'session_id' => $this->session->id,
            'measurements' => [
                [
                    'temp' => 120.0,
                    'sequence' => 1,
                ],
                [
                    'temp' => 122.4,
                    'sequence' => 2,
                ],
            ],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(200);
    }
}
