<?php

/**
 * CarrierError Model
 *
 * This model represents a single error message reported by a carrier
 * in the existing database. The application only *reads* from this table;
 * no inserts or updates are performed by Laravel.
 *
 * The model provides:
 * - Type casting (e.g., converting the carrier column into an enum)
 * - Query scopes for filtering active (non-deleted) errors
 * - A scope for selecting errors belonging to specific carriers
 *
 * The table already exists in the external system, so no migrations
 * or schema management are handled within this Laravel project.
 */

namespace App\Models;

use App\Enums\Carrier;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Represents a single carrier-related error coming from the existing database.
 * We only READ from this table; no migrations are required on our side.
 */
class CarrierError extends Model
{
    //Name of the existing table in your database
    protected $table = 'carrier_errors';

    //We only read the fields
    protected $fillable = [
        'carrier',
        'message',
        'is_deleted',
    ];

    /**
     * Casts ensure the model converts database values into proper PHP types:
     * - `is_deleted` becomes a boolean (0 → false, 1 → true)
     * - `carrier` becomes a Carrier enum instance (if supported by the Laravel version)
     */
    protected $casts = [
        'is_deleted' => 'boolean',
        'carrier' => Carrier::class, //If this doesn't work, use 'string'
    ];

    /**
     * Query Scope: notDeleted()
     *
     * Filters the query so we only fetch errors that are not soft-deleted.
     * In this system:
     * - is_deleted = 0 → active error (should be shown)
     * - is_deleted = 1 → removed/inactive (should NOT be shown)
     *
     * Usage:
     *      CarrierError::notDeleted()->get();
     */
    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->where('is_deleted', 0);
    }

    /**
     * Query Scope: forCarriers()
     *
     * Limits the query to errors related to a specific list of carriers.
     * The `$carriers` argument is an array of Carrier enum cases, which
     * we convert to their underlying string values before filtering.
     *
     * Usage:
     *      CarrierError::forCarriers([Carrier::GLS, Carrier::DFM])->get();
     */
    public function scopeForCarriers(Builder $query, array $carriers): Builder
    {
        // Convert enum objects (Carrier::GLS) into string values ("GLS")
        $carrierValues = array_map(fn (Carrier $c) => $c->value, $carriers);

        // Filter the database rows by allowed carriers
        return $query->whereIn('carrier', $carrierValues);
    }
}
