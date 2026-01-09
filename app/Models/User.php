<?php

/**
 * User
 *
 * This model represents a user in the system.
 *
 * It is responsible for:
 * - authentication (logging in / staying logged in)
 * - identifying who performs actions in the system
 *
 * In our system, the user model is mainly used to:
 * - associate exceptions with a specific user (when relevant)
 * - control access to the frontend and internal tools
 *
 * This class is largely based on Laravel’s default User model,
 * because it already handles authentication securely and reliably.
 */

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /**
     * These traits add common user-related functionality.
     *
     * HasFactory: Allows us to create test users easily (for development/testing)
     * Notifiable: Allows the user to receive notifications (e.g. email, Slack, or other channels)
     */
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * These are the fields that are allowed to be mass assigned.
     *
     * This protects the model from accidentally accepting unexpected or unsafe input.
     * Only these fields can be set when creating or updating a user.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * These fields are hidden when the user is converted to an array or JSON.
     * This prevents sensitive information from being exposed
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * This defines how certain fields should be automatically
     * converted when they are read from or written to the database.
     *
     * For example:
     * - email_verified_at is handled as a date/time object
     * - password is automatically hashed when it is set
     *
     * This keeps security and data handling consistent
     * without requiring extra code elsewhere.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
