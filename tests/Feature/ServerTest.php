<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function assert;
use function sprintf;

class ServerTest extends TestCase
{
    use RefreshDatabase;

    public function testThatServersCanBeRetrieved(): void
    {
        Server::factory()->count(50)->create();

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson('/servers');

        $response->assertStatus(200);
        $response->assertJsonCount(25, 'data');
        $response->assertJsonStructure(['data', 'meta', 'links']);
        $response->assertJsonPath('meta.total', 50);
    }

    public function testThatASpecificServerCanBeRetrievedByItsId(): void
    {
        $server = Server::factory()->create();

        assert($server instanceof Server);

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson(sprintf('/servers/%d', $server->id));

        $response->assertStatus(200)
            ->assertJsonStructure(['id', 'name', 'hostname', 'config_path', 'created_at', 'updated_at']);
    }

    public function testThatANewServerCanBeCreated(): void
    {
        $data = [
            'name' => 'New Server',
            'hostname' => 'localhost.localdomain',
        ];

        $response = $this
            ->actingAs(User::factory()->create())
            ->postJson('/servers', $data);

        $response->assertStatus(200)
            ->assertJsonPath('id', 1);
    }

    public function testThatAnExistingServerCanBeUpdated(): void
    {
        $server = Server::factory()->create();

        assert($server instanceof Server);

        $data = [
            'name' => 'Update Existing',
            'hostname' => $server->hostname,
        ];

        $response = $this
            ->actingAs(User::factory()->create())
            ->putJson(sprintf('/servers/%d', $server->id), $data);

        $response->assertStatus(200);
    }

    public function testThatAnExistingServerCanBeDeleted(): void
    {
        $server = Server::factory()->create();

        assert($server instanceof Server);

        $response = $this
            ->actingAs(User::factory()->create())
            ->deleteJson(sprintf('/servers/%d', $server->id));

        $response->assertStatus(200);
    }
}
