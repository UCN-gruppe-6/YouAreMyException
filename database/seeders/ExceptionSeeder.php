<?php

/**
 * ExceptionSeeder
 *
 * This seeder is used to import raw exception data from a JSON file into the database.
 *
 * In our system, this represents a more "low-level" exception format
 * compared to the structured exceptions used later in the pipeline.
 *
 * The purpose of this seeder is to:
 * - load exception data exactly as it is stored in JSON
 * - normalize it so it fits the database schema
 * - ensure database constraints are respected
 *
 * This allows us to work with realistic exception data during
 * development and testing without relying on real runtime errors.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelExceptionAnalyzer\Models\ExceptionModel;

class ExceptionSeeder extends Seeder
{
    // The maximum length allowed by $table->string() in the database
    private const MAX_MESSAGE_LENGTH = 255;

    /**
     * Run the seeder.
     *
     * This method:
     * - loads the exception JSON file
     * - validates that it exists and is readable
     * - cleans and adapts each exception entry
     * - inserts the data into the database
     */
    public function run()
    {
        // Build the path to the JSON file containing exception data
        $jsonPath = database_path('seeders/exceptions.json');

        // If the file does not exist, we log the error and stop. There is no point continuing without input data.
        if (!File::exists($jsonPath)) {
            Log::error("Exception data file not found at: {$jsonPath}");
            return;
        }

        // Read the raw JSON file.
        // Decode the JSON into a PHP array.
        // If decoding failed, we log the issue and stop.
        $jsonContents = File::get($jsonPath);
        $exceptions = json_decode($jsonContents, true);

        if (!is_array($exceptions)) {
            Log::error("Failed to decode JSON data from: {$jsonPath}");
            return;
        }

        $count = 0;

        // Loop through each exception entry in the JSON file.
        foreach ($exceptions as $exceptionData) {

            /**
             * STEP 1: Ensure the message fits the database
             * Some exception messages can be very long. We truncate them so they fit
             * into the database column instead of causing insert errors.
             */
            if (isset($exceptionData['message'])) {
                $exceptionData['message'] = $this->truncateMessage($exceptionData['message']);
            }

            /**
             * STEP 2: Normalize stack trace format
             *
             * In the JSON file, the stack trace is stored as an array under the key "stacktrace".
             * In the database, it is stored as a TEXT column called "stack_trace", so we:
             * - convert the array to a JSON string
             * - rename the key to match the column name
             */
            if (isset($exceptionData['stacktrace']) && is_array($exceptionData['stacktrace'])) {
                // Encode the PHP stack trace array into a JSON string for the 'stack_trace' TEXT column
                $exceptionData['stack_trace'] = json_encode($exceptionData['stacktrace'], JSON_PRETTY_PRINT);

                // Remove the original 'stacktrace' key
                unset($exceptionData['stacktrace']);
            }

            /**
             * STEP 3: Fill in missing or optional fields
             *
             * Some fields may not always be present in the JSON.
             * We provide safe default values so the database insert does not fail.
             */
            $exceptionData['session_id'] = $exceptionData['session_id'] ?? Str::uuid()->toString();
            $exceptionData['created_at'] = $exceptionData['created_at'] ?? now();
            $exceptionData['user_id'] = $exceptionData['user_id'] ?? null;
            $exceptionData['user_email'] = $exceptionData['user_email'] ?? null;
            $exceptionData['level'] = $exceptionData['level'] ?? 'error';


            // Insert the exception record into the database.
            try {
                ExceptionModel::create($exceptionData);
                $count++;

                // If insertion fails, we log the error and continue.
                // One bad record should not stop the entire import.
            } catch (\Illuminate\Database\QueryException $e) {
                Log::error("Failed to insert exception: " . $exceptionData['message'], ['exception' => $e->getMessage()]);
                continue;
            }
        }

        // Log a summary once the seeding process is complete.
        Log::info("Exception Seeder finished. Successfully created {$count} exception records.");
    }

    /**
     * Helper method used to safely shorten exception messages.
     * If a message exceeds the database limit, it is cut down
     * and suffixed with "...".
     *
     * @param string $message
     * @return string
     */
    private function truncateMessage(string $message): string
    {
        // Use the Laravel Str::limit helper for clean truncation
        return Str::limit($message, self::MAX_MESSAGE_LENGTH);

        /* // Alternative manual implementation using PHP standard function:
        $limit = self::MAX_MESSAGE_LENGTH;
        if (mb_strlen($message) > $limit) {
            return mb_substr($message, 0, $limit - 3) . '...';
        }
        return $message;
        */
    }
}
