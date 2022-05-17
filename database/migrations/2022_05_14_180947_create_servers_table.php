<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.FunctionLength.FunctionLength,SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('servers', static function (Blueprint $table): void {
            $table->id();

            $table->string('name')
                ->comment('The internal name of the server');

            $table->string('hostname')
                ->default('127.0.0.1')
                ->comment('The server hostname');

            $table->string('config_path')
                ->default('/etc/haproxy/haproxy.conf')
                ->comment('The internal path on the server to the haproxy configuration file.');

            $table->boolean('show_stats')
                ->default(false)
                ->comment('Whether stats are enabled or not');

            $table->string('stats_uri')
                ->nullable()
                ->comment('The endpoint to render stats from');

            $table->string('stats_user')
                ->nullable()
                ->comment('The stats username');

            $table->string('stats_password')
                ->nullable()
                ->comment('The stats password (stored in plain-text!)');

            $table->text('extra_defaults')
                ->nullable()
                ->comment('Additional configuration values to append for the defaults section');

            $table->text('extra_globals')
                ->nullable()
                ->comment('Additional configuration values to append for the globals section');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('servers');
    }
};
