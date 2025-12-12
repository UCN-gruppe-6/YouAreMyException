<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use LaravelExceptionAnalyzer\Models\ExceptionModel;
use LaravelExceptionAnalyzer\Models\StructuredExceptionModel;

class AIExceptionSeeder extends Seeder
{


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



