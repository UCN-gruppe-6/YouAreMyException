<?php

/**
 * DatabaseSeeder
 *
 * This is the main database seeder.
 *
 * It acts as the entry point for all other seeders in the system.
 * When we run: php artisan db:seed
 * Laravel starts here and then executes the seeders listed below.
 *
 * In our system, we use this file to:
 * - control which seeders run
 * - define the order they run in
 * - make sure the database is populated consistently
 *
 * This keeps database setup predictable and repeatable.
 */

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     *
     * This method decides which seeders should be executed.
     * Nothing is seeded automatically unless it is listed here.
     */
    public function run(): void
    {
        // Example user seeding was used earlier during development
        // User::factory(10)->create();

        // Run the seeders that populate exception-related data.
        $this->call([
            ExceptionSeeder::class,
            AIExceptionSeeder::class
        ]);

// This was an example of creating a single test user.
//        User::factory()->create([
//            'name' => 'Test User',
//            'email' => 'test@example.com',
//        ]);
    }
}
