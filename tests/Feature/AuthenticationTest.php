<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function testThatAUserCanLoginToTheApplication(): void
    {
        $user = User::factory()->create();
        $request = [
            'email' => $user->email,
            'password' => 'password',
        ];

        $response = $this->postJson('/auth/token', $request);

        $response->assertStatus(200)
            ->assertJsonStructure(['access_token', 'expires_in_minutes', 'expires_at']);
    }

    public function testThatALoginAttemptWithMissingDataReturnsAValidationError(): void
    {
        $response = $this->postJson('/auth/token', ['email' => 'test@example.com', 'password' => 'pass']);

        $response->assertStatus(422)
            ->assertJsonStructure(['message', 'errors' => ['password']]);
    }

    public function testThatAnUnsuccessfulAuthAttemptReturnsAnError(): void
    {
        $response = $this->postJson('/auth/token', ['email' => 'test@example.com', 'password' => 'invalid-password']);

        $response->assertStatus(403)
            ->assertJsonStructure(['error']);
    }

    public function testThatAnAuthenticatedUserCanViewTheirProfile(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->getJson('/auth/me');

        $response->assertStatus(200)
            ->assertJson(['id' => $user->id, 'email' => $user->email]);
    }

    public function testThatAnAuthenticatedUserCanLogout(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->deleteJson('/auth/logout');

        $response->assertStatus(200)
            ->assertJsonStructure(['success']);
    }
}
