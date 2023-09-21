<?php

namespace Tests\Feature;

use App\Models\Board;
use Tests\TestCase;

class ApiCreateSessionTest extends TestCase
{
    protected Board $board;

    public function setUp(): void
    {
        parent::setUp();
        $this->board = Board::factory()->create();
    }

    public function test_create_session_wrong_body_fields(): void
    {
        $response = $this->postJson(route('api.session.store'), [
            'strangeField' => 'strangeValue',
            'anotherField' => 'otherValue',
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_create_session_wrong_field_values(): void
    {
        $response = $this->postJson(route('api.session.store'), [
            'soak_temperature' => '10',
            'soak_time' => 1,
            'reflow_gradient' => 4,
            'ramp_up_gradient' => true,
            'reflow_max_time' => 5,
            'cooldown_gradient' => -6,
            'reflow_peak_temp' => '6',
        ], ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]);

        $response->assertStatus(422);
    }

    public function test_create_session(): void
    {
        $response = $this->postJson(
            route('api.session.store'),
            [
                'soak_time' => 70,
                'soak_temperature' => 100,
                'reflow_gradient' => 2,
                'reflow_peak_temp' => 183,
                'reflow_max_time' => 120,
                'ramp_up_gradient' => 5,
                'cooldown_gradient' => -6,
            ],
            ['Authorization' => "Basic {$this->board->uuid}:{$this->board->uuid}"]
        );

        $response->assertOk();
    }
}
