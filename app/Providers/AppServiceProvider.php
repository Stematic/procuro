<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Services to register.
    }

    public function boot(): void
    {
        // Called when the application is booted.
    }
}
