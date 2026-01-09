<?php

/**
 * AIBulkCommand
 *
 * Our system is built around storing and showing exceptions that already exist
 * in the database. Normally, those rows are created when real errors happen in the application.
 * But when we are developing or testing the system, we do not want to constantly
 * break the application just to get data to work with.
 *
 * This command solves that problem. It lets us manually insert
 * realistic exception records into the database whenever we need them.
 *
 * Important to understand:
 * - This command does NOT throw or catch real exceptions
 * - It does NOT run automatically
 * - It only runs when we explicitly execute it via Artisan
 *
 * Think of it as a way to "pre-fill" the system with example exceptions
 * so the rest of the application can be built and tested properly.
 */

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use LaravelExceptionAnalyzer\Models\StructuredExceptionModel;
use Illuminate\Support\Str;

class AIBulkCommand extends Command
{
    /**
     * This defines how the command is called from the terminal.
     * Example: php artisan ai:seed-first-exception 50
     *
     * The optional "count" argument decides how many rows
     * should be inserted into the database. If no number is provided, it defaults to 10.
     */
    protected $signature = 'ai:seed-first-exception {count=10}';

    /**
     * This is just a human-readable description.
     * It shows up when running:
     * - php artisan list OR php artisan help ai:seed-first-exception
     *
     * It helps other developers understand what the command does without opening the file.
     */
    protected $description = 'Seed the first exception from AIException.json multiple times';

    /**
     * This method runs when the command is executed.
     * It does NOT run automatically. Only when a developer calls the command.
     *
     * The goal here is:
     * - Load example exception data from a JSON file
     * - Take one exception as a template
     * - Insert it into the database multiple times
     *
     * Flow overview:
     *  - Loads a predefined JSON file containing example exception data and decodes the JSON into a PHP array.
     *  - Uses the first exception entry as a template.
     *  - Reads a "count" argument from the command line to determine how many times the exception should be inserted.
     *  - Iteratively inserts the same exception into the database to simulate multiple similar errors occurring in the system.
     *  - Wraps each insert in a try/catch block so a single database failure does not interrupt the entire operation.
     *  - Logs database or constraint errors instead of throwing real exceptions.
     *  - Outputs a summary of how many rows were successfully inserted.
     *
     *  This command does not trigger real application exceptions.
     *  It only creates database records that mimic real exception data.
     */
    public function handle()
    {
        // Build the full path to the JSON file that contains example exception data.
        $jsonPath = database_path('seeders/AIException.json');

        // Read the contents of the JSON file into a string. At this point, it is just raw text.
        // Next we convert the JSON string into a PHP array so we can easily access individual values.
        $jsonContents = File::get($jsonPath);
        $exceptions = json_decode($jsonContents, true);

        // Takes the first exception from the JSON file and uses it as a reusable template.
        // We repeat this same structure to simulate multiple similar exceptions in the system.
        // Read the "count" value provided in the terminal. This decides how many rows we try to insert.
        $firstException = $exceptions[0];
        $countToInsert = (int) $this->argument('count');
        // Keep track of how many inserts actually succeed. This is useful in case some inserts fail.
        $inserted = 0;

        // Loop as many times as requested and insert the same exception data over and over.
        // Insert a new row into the database using the StructuredExceptionModel.
        // This does NOT throw a real exception. It only creates a database record that looks like a real exception.
        for ($i = 0; $i < $countToInsert; $i++) {
            try {
                StructuredExceptionModel::create([
                    'exception_id' => $firstException['exception_id'],
                    'user_id' => $firstException['user_id'] ?? null,
                    'affected_carrier' => $firstException['affected_carrier'] ?? null,
                    'is_internal' => $firstException['is_internal'],
                    'severity' => $firstException['severity'],
                    'concrete_error_message' => $firstException['concrete_error_message'],
                    'full_readable_error_message' => $firstException['full_readable_error_message'],
                    'code' => $firstException['code'],
                    'file_name' => $firstException['file_name'],
                    'line_number'=>$firstException['line_number'],
                    'cfl' => $firstException['cfl'],// optional unique
                ]);
                // Only increase the counter if the insert worked.
                $inserted++;
            } catch (\Exception $e) {
                // If something goes wrong here, it is a database or constraint problem — not an application error.
                // We log it and continue so one failure does not stop the entire seeding process.
                Log::error("Failed to insert exception: " . $e->getMessage());
            }
        }

        // Print a short summary in the terminal so we know how many rows were actually inserted.
        $this->info("Inserted the first exception {$inserted} times.");
        // Returning 0 signals that the command finished successfully.
        return 0;
    }
}
