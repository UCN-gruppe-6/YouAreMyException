<?php

/**
 * Providers
 *
 * This file tells Laravel which service providers should be loaded
 * when the application starts.
 * Service providers are classes that run during application startup
 * and are used to register or configure global behavior.
 *
 * In our system, we currently only load AppServiceProvider,
 * because we do not need any additional global setup yet.
 */

return [
    App\Providers\AppServiceProvider::class,
];
