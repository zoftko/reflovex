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

        $response->assertStatus(201);
    }

    public function test_measurements_create_no_session(): void
    {
        $newBoard = Board::factory()->create();
        $response = $this->postJson(route('api.measurement.store'), [
            'measurements' => [
                [
                    'temp' => 30.5,
                    'sequence' => 1,
                ],
                [
                    'temp' => 32.75,
                    'sequence' => 2,
                ],
            ],
        ], ['Authorization' => "Basic {$newBoard->uuid}:{$newBoard->uuid}"]);

        $response->assertStatus(400);
    }

    public function test_measurements_create_without_session(): void
    {
        $response = $this->postJson(route('api.measurement.store'), [
            'measurements' => [
                [
                    'temp' => 30.5,
                    'sequence' => 1,
                ],
                [
                    'temp' => 32.75,
                    'sequence' => 2,
                ],
            ],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);
        $response->assertStatus(201);
        self::assertEquals(2, $this->session->measurements()->count());

        $response = $this->postJson(route('api.measurement.store'), [
            'measurements' => [
                [
                    'temp' => 35,
                    'sequence' => 3,
                ],
            ],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);
        $response->assertStatus(201);
        self::assertEquals(3, $this->session->measurements()->count());

        $newSession = Session::factory()->create(['board_id' => $this->board->id]);
        $response = $this->postJson(route('api.measurement.store'), [
            'measurements' => [
                [
                    'temp' => 35,
                    'sequence' => 1,
                ],
            ],
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(201);
        self::assertEquals(3, $this->session->measurements()->count());
        self:self::assertEquals(1, $newSession->measurements()->count());
    }
}
