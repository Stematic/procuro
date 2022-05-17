<?php

declare(strict_types=1);

// phpcs:disable SlevomatCodingStandard.Files.FunctionLength.FunctionLength,SlevomatCodingStandard.Functions.FunctionLength.FunctionLength

use App\Models\Server;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDomainsTable extends Migration
{
    public function up(): void
    {
        Schema::create('domains', static function (Blueprint $table): void {
            $table->id();

            $table->foreignIdFor(Server::class);

            $table->string('domain')
                ->comment('The fully qualified domain name for the website');

            $table->string('route')
                ->comment('The internal hostname to route to');

            $table->integer('port')
                ->default(80)
                ->comment('The internal port to use for the backend server');

            $table->boolean('is_secure')
                ->default(true)
                ->comment('Determines if the domain should be secured');

            $table->boolean('is_letsencrypt')
                ->default(true)
                ->comment('Determines whether the site should generate an SSL certificate automatically');

            $table->timestamp('renew_at')
                ->nullable()
                ->comment('The renewal date of the installed SSL certificate');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('domains');
    }
}
