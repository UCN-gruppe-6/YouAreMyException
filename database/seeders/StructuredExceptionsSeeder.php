<?php

/**
 * StructuredExceptionSeeder
 *
 * This seeder inserts simple example data into the "structured_exceptions" table.
 *
 * The data here is NOT real exception data and NOT generated
 * from the actual exception pipeline.
 *
 * Its only purpose is to:
 * - give the frontend something to display
 * - test basic UI behavior (lists, empty states, flags)
 * - show how different carriers may or may not have errors
 *
 * In other words: this is purely test/demo data.
 */

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StructuredExceptionsSeeder extends Seeder
{
    /**
     * Run the seeder.
     *
     * This method inserts a small, fixed set of rows that
     * represent different carriers with and without errors.
     */
    public function run(): void
    {
        DB::table('structured_exceptions')->insert([
            [
                'carrier' => 'GLS',
                'message' => 'Label-generering fejler for nogle forsendelser.',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'carrier' => 'DFM',
                'message' => 'Servicepoint-opslag fungerer ikke for visse postnumre.',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'carrier' => 'PACKETA',
                'message' => 'API svarer langsomt — risiko for timeouts.',
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'carrier' => 'BRING',
                'message' => null, // ingen fejl
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'carrier' => 'POSTNORD',
                'message' => null, // ingen fejl
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'carrier' => 'DAO',
                'message' => null, // ingen fejl
                'is_deleted' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
