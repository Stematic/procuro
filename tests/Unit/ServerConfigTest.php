<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Exceptions\InvalidStub;
use App\Models\Domain;
use App\Models\Server;
use App\Services\ServerConfigBuilder;
use App\Services\ServerConfigGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

use function file_get_contents;
use function assert;

class ServerConfigTest extends TestCase
{
    use RefreshDatabase;

    public function testThatTheDefaultConfigCanBeGenerated(): void
    {
        $generator = $this->getGenerator([
            'file' => 'defaults.stub',
        ]);

        $content = $generator->generate([
            'extra_defaults' => '',
        ]);

        $valid = file_get_contents(__DIR__ . '/../resources/default.valid.stub');

        $this->assertEquals($valid, $content);
    }

    public function testThatConditionalsAreValidated(): void
    {
        $generator = $this->getGenerator([
            'file' => 'defaults.stub',
        ]);

        $content = $generator->generate([
            'stats' => true,
            'stats_uri' => '/stats',
            'stats_user' => 'test',
            'stats_password' => 'password',
            'extra_defaults' => '',
        ]);

        $valid = file_get_contents(__DIR__ . '/../resources/defaults.valid.conditional.stub');

        $this->assertEquals($valid, $content);
    }

    public function testThatAnInvalidStubFileRaisesAnException(): void
    {
        $this->expectException(InvalidStub::class);

        $generator = $this->getGenerator([
            'file' => 'invalid-stub.stub',
        ]);

        $generator->generate([]);
    }

    public function testThatANonSuppliedKeyRemainsUnreplaced(): void
    {
        $generator = $this->getGenerator([
            'file' => 'defaults.stub',
        ]);

        $content = $generator->generate([]);

        $this->assertStringContainsString('{{extra_defaults}}', $content);
    }

    public function testThatAFullServerConfigurationFileCanBeGenerated(): void
    {
        $server = Server::factory()->create([
            'name' => 'Stematic',
            'hostname' => 'stematic',
        ]);

        assert($server instanceof Server);

        Domain::factory()->create([
            'server_id' => $server,
            'domain' => 'stematic.co.uk',
            'route' => 'gerlach',
            'port' => 1750,
        ]);

        Carbon::setTestNow(Carbon::now()->year(2022)->month(01)->day(01)->startOfDay());

        $builder = ServerConfigBuilder::make($server);

        $contents = $builder->build();

        $valid = file_get_contents(__DIR__ . '/../resources/full.valid.stub');

        $this->assertEquals($valid, $contents);
    }

    /**
     * @param array<string, mixed> $arguments
     */
    protected function getGenerator(array $arguments): ServerConfigGenerator
    {
        $generator = resolve(ServerConfigGenerator::class, $arguments);

        assert($generator instanceof ServerConfigGenerator);

        return $generator;
    }
}
