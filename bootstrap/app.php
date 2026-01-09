<?php

/**
 * App
 *
 * This file is the entry point where the Laravel application
 * is configured before it starts running.
 *
 * It tells Laravel:
 * - where routes live
 * - where console commands live
 * - which background tasks should run automatically
 *
 * Think of this file as the place where we wire the application together.
 */

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    /**
     * Routing configuration
     *
     * Here we tell Laravel where different types of routes are defined.
     * - web.php: routes used for the frontend (Blade pages)
     * - console.php: routes that define Artisan commands
     * - health: a simple endpoint used to check if the app is alive
     */
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )

    /**
     * Middleware configuration
     *
     * Middleware runs before or after requests.
     */
    ->withMiddleware(function (Middleware $middleware): void {
        // No global middleware is configured at the moment.
    })

    /**
     * Exception configuration
     *
     * This is where global exception handling behavior can be customized.
     */
    ->withExceptions(function (Exceptions $exceptions): void {
        // No custom global exception configuration is needed right now.

    })

    /**
     * Scheduled tasks
     *
     * This section defines commands that should run automatically at fixed intervals.
     *
     * Laravel's scheduler replaces traditional system cron jobs with application-level scheduling.
     *
     * These commands are part of our exception processing pipeline:
     * - collecting structured exceptions
     * - analyzing them
     * - resolving or marking them as handled
     *
     * They run in the background without user interaction.
     */
    ->withSchedule(function (Schedule $schedule) {
        // Previously used test command to verify scheduling:
        //$schedule->command('exceptions:classify')->everyMinute();

        // Collect or normalize structured exceptions
        $schedule->command('exceptions:structured')->everyMinute();
        // Analyze exceptions (e.g. categorization, severity, AI processing)
        $schedule->command('analyze:exception')->everyMinute();
        // Resolve or update exception states after analysis
        $schedule->command('resolve:exceptions')->everyThreeMinutes();
    })
    /**
     * Finally, create and boot the application with all the configuration defined above.
     */
    ->create();
