<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use LaravelExceptionAnalyzer\Models\StructuredExceptionModel;
use Illuminate\Support\Str;

class AIBulkCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * You can also pass an optional count parameter, default 10
     */
    protected $signature = 'ai:seed-first-exception {count=10}';

    /**
     * The console command description.
     */
    protected $description = 'Seed the first exception from AIException.json multiple times';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $jsonPath = database_path('seeders/AIException.json');



        $jsonContents = File::get($jsonPath);
        $exceptions = json_decode($jsonContents, true);


        $firstException = $exceptions[0];
        $countToInsert = (int) $this->argument('count');
        $inserted = 0;

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
                $inserted++;
            } catch (\Exception $e) {
                Log::error("Failed to insert exception: " . $e->getMessage());
            }
        }

        $this->info("Inserted the first exception {$inserted} times.");
        return 0;
    }
}
