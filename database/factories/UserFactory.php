<?php

/**
 * UserFactory
 *
 * This factory is used to quickly create User records for development and testing.
 *
 * Instead of manually creating users in the database,
 * this factory lets us generate realistic-looking users
 * whenever we need them.
 *
 * In our system, this is useful for:
 * - testing authentication
 * - testing user-related functionality
 * - associating exceptions with users during development
 *
 * This factory is NOT used in production.
 * It only exists to support development, testing, and demos.
 *
 * @extends Factory<\App\Models\User>
 */

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * This static property is used to reuse the same hashed password for all generated users.
     *
     * Why:
     * - We don’t need a unique password per test user
     * - Reusing the hash makes factory usage faster and simpler
     */
    protected static ?string $password;

    /**
     * Define the default data for a generated User.
     *
     * Every time we create a user using this factory,
     * these values will be used unless overridden.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     * Optional state that creates a user with an unverified email.
     *
     * This allows us to test scenarios where email verification has not yet been completed.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
