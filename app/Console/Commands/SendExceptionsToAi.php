<?php

/**
 * SendExceptionsToAi
 *
 * This command is used to verify that our scheduled jobs (Laravel Scheduler)
 * are actually running as expected.
 *
 * Right now, it acts as a simple test:
 * - It writes a log entry to the database
 * - It confirms that the command was executed
 * - It helps us verify that the schedule is working
 *
 * Important:
 * - This command does NOT send anything to AI yet
 * - It does NOT process real exceptions
 * - It is only a technical proof that scheduled commands run correctly
 */

namespace App\Console\Commands;

use App\Models\AiJobTestLog;
use Illuminate\Console\Command;


class SendExceptionsToAi extends Command
{
    /**
     * This is the name of the Artisan command.
     * Example: php artisan exceptions:classify
     */
    protected $signature = 'exceptions:classify';

    /**
     * Short description shown in Artisan command lists.
     * This is mainly for developer clarity when running: php artisan list
     */
    protected $description = 'Command description';

    /**
     * This method runs when the command is executed.
     *
     * It can be triggered in two ways:
     * - Manually via: php artisan exceptions:classify
     * - Automatically via the Laravel scheduler (Kernel)
     *
     * The purpose of this implementation is NOT business logic,
     * but to confirm that scheduled execution works end-to-end.
     */
    public function handle()
    {
        // Create a simple database record so we have proof that the command ran.
        // If this record appears, the scheduler is working.
        AiJobTestLog::create([
            'message' => 'Dette er en test. Jobbet kørte kl. ' . now(),
        ]);

        // Output feedback to the terminal when run manually.
        $this->info('Testbesked er gemt i databasen!');

        // This message makes it explicit what is being tested.
        $this->info('Denne test tester schedule funktion i Kernel');
    }
}
