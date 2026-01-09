<?php

/**
 * AIExceptionSeeder
 *
 * This seeder is used to populate the database with example
 * structured exceptions taken from a JSON file.
 *
 * In our system, the frontend and analysis logic depend on
 * exception records already existing in the database.
 *
 * Instead of waiting for real errors to occur, this seeder
 * allows us to insert realistic exception data in one step.
 *
 * The data inserted here behaves exactly like real exceptions
 * created during runtime.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelExceptionAnalyzer\Models\ExceptionModel;
use LaravelExceptionAnalyzer\Models\StructuredExceptionModel;

class AIExceptionSeeder extends Seeder
{

    /**
     * Run the database seeder.
     *
     * This method is executed when we run: php artisan db:seed
     * or when this seeder is called from another seeder.
     *
     * Flow overview:
     *  This method loads a JSON file containing example exception data,
     *  converts it into a PHP array, and inserts each entry into the database
     *  as a structured exception record.
     *
     *  The process works like this:
     *  1. Locate and read the JSON file from the database/seeders directory
     *  2. Decode the JSON so it can be processed in PHP
     *  3. Loop through each exception entry in the file
     *  4. Insert each entry as a StructuredExceptionModel record
     *  5. Keep track of how many inserts succeed
     *  6. Log the final count for verification
     *
     *  If a single insert fails, the error is logged and the process continues,
     *  so one bad record does not stop the entire seeding operation.
     */
    public function run()
    {
        $jsonPath = database_path('seeders/AIException.json');

        $jsonContents = File::get($jsonPath);
        $exceptions = json_decode($jsonContents, true);

        $count = 0;

        foreach ($exceptions as $data) {
            try {
                StructuredExceptionModel::create([
                    'exception_id' => $data['exception_id'],
                    'user_id' => $data['user_id'] ?? null,
                    'affected_carrier' => $data['affected_carrier'] ?? null,
                    'is_internal' => $data['is_internal'],
                    'severity' => $data['severity'],
                    'concrete_error_message' => $data['concrete_error_message'],
                    'full_readable_error_message' => $data['full_readable_error_message'],
                    'code' => $data['code'],
                    'file_name' => $data['file_name'],
                    'line_number'=>$data['line_number'],
                    'cfl' => $data['cfl'],
                ]);
                $count++;
            } catch (\Exception $e) {
                Log::error("Failed to insert exception" );
            }
        }

        Log::info("StructuredExceptionSeeder Inserted {$count} ");
    }
}



