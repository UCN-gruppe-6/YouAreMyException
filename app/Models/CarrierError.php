<?php

/**
 * Model that reads the existing table in the database
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

    //We only read
    protected $fillable = [
        'carrier',
        'message',
        'is_deleted',
    ];

    /**
     * Cast columns to proper PHP types
    */
    protected $casts = [
        'is_deleted' => 'boolean',
        'carrier' => Carrier::class, //If this doesn't work, use 'string'
    ];

    /**
     * Scope: Only errors that are not soft deleted will be collected.
     * is_deleted = 0 --> it's shown.
     * is_deleted = 1 --> not shown for the customer.
    */
    public function scopeNotDeleted(Builder $query): Builder
    {
        return $query->where('is_deleted', 0);
    }

    /**
     * Scope: only errors for the given carriers.
     * @param Carrier[] $carriers
     */
    public function scopeForCarriers(Builder $query, array $carriers): Builder
    {
        $carrierValues = array_map(fn (Carrier $c) => $c->value, $carriers);

        return $query->whereIn('carrier', $carrierValues);
    }
}
