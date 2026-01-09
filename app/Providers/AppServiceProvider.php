<?php

/**
 * AppServiceProvider
 *
 * This file is part of Laravel’s startup process.
 *
 * Every time the application starts - whether for:
 * - a web request
 * - an Artisan command
 * - a queued job
 * - or a scheduled task
 *
 * Laravel loads this service provider.
 *
 * This gives us a single, guaranteed place to run code
 * before the application begins doing any real work.
 *
 * In our system, we currently do not need any global setup,
 * so the provider is intentionally empty.
 *
 * It is kept so future global configuration or bindings
 * have a clear and correct place to live.
 */

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * This method is used to register things in the service container.
     * It runs very early in the application lifecycle.
     */
    public function register(): void
    {
        // No custom service registrations are needed at the moment.
    }

    /**
     * This method runs after all services have been registered.
     * It is used to "boot" application-wide behavior.
     */
    public function boot(): void
    {
        // No application-wide boot logic is required right now.
    }
}
