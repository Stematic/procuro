<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Http\Middleware\TrustHosts;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Tests\TestCase;

class StaticTest extends TestCase
{
    public function testThatTheApplicationVersionCanBeSeen(): void
    {
        $response = $this->get('/');

        $response
            ->assertStatus(200)
            ->assertJsonStructure(['application', 'version']);
    }

    public function testTrustHostsMiddleware(): void
    {
        $middleware = new TrustHosts(app());

        $this->assertIsArray($middleware->hosts());
    }
}
