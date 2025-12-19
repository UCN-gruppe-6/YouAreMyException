<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StructuredExceptionsSeeder extends Seeder
{
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
