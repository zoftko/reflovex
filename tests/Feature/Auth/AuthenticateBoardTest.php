<?php

namespace Feature\Auth;

use App\Models\Board;
use Tests\TestCase;

class AuthenticateBoardTest extends TestCase
{
    public function test_valid_credentials(): void
    {
        $uuid = Board::factory()->create()->uuid;
        $response = $this->getJson(
            route('api.health.index'),
            headers: ['Authorization' => "Basic $uuid:$uuid"]
        );

        $response->assertOk();
    }

    public function test_credentials_missing_user(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic :myuuid']);
        $this->assertEquals(401, $response->status());
    }

    public function test_credentials_missing_password(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic myuuid:']);
        $this->assertEquals(401, $response->status());
    }

    public function test_credentials_malformed(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic randomcrap']);
        $this->assertEquals(401, $response->status());
    }

    public function test_credentials_missing_scheme(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Hello world']);
        $this->assertEquals(401, $response->status());
    }
}
