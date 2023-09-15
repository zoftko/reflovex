<?php

namespace Tests\Feature;

use App\Models\Board;
use Tests\TestCase;

class AuthenticateBoardTest extends TestCase
{
    public function testValidCredentials(): void
    {
        $uuid = Board::factory()->create()->uuid;
        $response = $this->getJson(
            route('api.health.index'),
            headers: ['Authorization' => "Basic $uuid:$uuid"]
        );

        $response->assertOk();
    }

    public function testCredentialsMissingUser(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic :myuuid']);
        $this->assertEquals(401, $response->status());
    }

    public function testCredentialsMissingPassword(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic myuuid:']);
        $this->assertEquals(401, $response->status());
    }

    public function testCredentialsMalformed(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Basic randomcrap']);
        $this->assertEquals(401, $response->status());
    }

    public function testCredentialsMissingScheme(): void
    {
        $response = $this->getJson(route('api.health.index'), headers: ['Authorization' => 'Hello world']);
        $this->assertEquals(401, $response->status());
    }
}
