<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Models\Domain;
use App\Models\Server;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ServerTest extends TestCase
{
    use RefreshDatabase;

    public function testThatAServerCanBeCreatedThroughTheFactory(): void
    {
        $server = Server::factory()->create();

        $this->assertInstanceOf(Server::class, $server);
        $this->assertTrue($server->exists);
    }

    public function testThatAServersDomainsCanBeRetrieved(): void
    {
        $server = Server::factory()->has(Domain::factory()->count(5))->create();

        $this->assertCount(5, $server->domains);
    }
}
