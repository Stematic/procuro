<?php

namespace Tests\Feature;

use App\Models\Domain;
use App\Models\Server;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function assert;
use function sprintf;

class DomainTest extends TestCase
{
    use RefreshDatabase;

    public function testThatDomainsCanBeRetrieved(): void
    {
        Domain::factory()
            ->for(Server::factory()->create(), 'server')
            ->count(50)
            ->create();

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson('/domains');

        $response->assertStatus(200);
        $response->assertJsonCount(25, 'data');
        $response->assertJsonStructure(['data', 'meta', 'links']);
        $response->assertJsonPath('meta.total', 50);
    }

    public function testThatASpecificDomainCanBeRetrievedByItsId(): void
    {
        $domain = Domain::factory()
            ->for(Server::factory()->create(), 'server')
            ->create();

        assert($domain instanceof Domain);

        $response = $this
            ->actingAs(User::factory()->create())
            ->getJson(sprintf('/domains/%d', $domain->id));

        $response->assertStatus(200)
            ->assertJsonStructure([
                'id',
                'domain',
                'route',
                'port',
                'backend',
                'is_secure',
                'is_letsencrypt',
                'renew_at',
                'created_at',
                'updated_at',
            ]);
    }

    public function testThatANewDomainCanBeCreated(): void
    {
        $server = Server::factory()->create();

        assert($server instanceof Server);

        $data = [
            'domain' => 'test.example.com',
            'route' => 'internal',
            'server_id' => $server->id,
        ];

        $response = $this
            ->actingAs(User::factory()->create())
            ->postJson('/domains', $data);

        $response->assertStatus(200)
            ->assertJsonPath('id', 1);
    }

    public function testThatAnExistingDomainCanBeUpdated(): void
    {
        $domain = Domain::factory()
            ->for(Server::factory()->create(), 'server')
            ->create();

        assert($domain instanceof Domain);

        $data = [
            'domain' => 'test.example.com',
            'route' => 'internal',
            'server_id' => $domain->server->id,
        ];

        $response = $this
            ->actingAs(User::factory()->create())
            ->putJson(sprintf('/domains/%d', $domain->id), $data);

        $response->assertStatus(200);
    }

    public function testThatAnExistingDomainCanBeDeleted(): void
    {
        $domain = Domain::factory()
            ->for(Server::factory()->create(), 'server')
            ->create();

        assert($domain instanceof Domain);

        $response = $this
            ->actingAs(User::factory()->create())
            ->deleteJson(sprintf('/domains/%d', $domain->id));

        $response->assertStatus(200);
    }
}
