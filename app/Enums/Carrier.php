<?php

namespace App\Enums;

/**
 * Carrier Enum
 *
 * This enum represents all carriers supported by the drift status system.
 * Using an enum ensures:
 * - A fixed and controlled list of valid carriers
 * - Cleaner filtering and mapping in the controller and model
 *
 * Each enum case corresponds to a carrier that must be displayed in the UI,
 * regardless of whether the database currently contains error data for it.
 */
enum Carrier: string
{
    case GLS = 'GLS';
    case DFM = 'DFM';
    case PACKETA = 'PACKETA';
    case BRING = 'BRING';
    case POSTNORD = 'POSTNORD';
    case DAO = 'DAO';

        /**
         * Returns a human-readable label for frontend display.
         *
         * The database may store uppercase codes, but the UI should show
         * a nicer formatted name (e.g., "Packeta" instead of "PACKETA").
         */
        public function label(): string
        {
            return match ($this) {
                self::GLS => 'GLS',
                self::DFM => 'DFM',
                self::PACKETA => 'Packeta',
                self::BRING => 'Bring',
                self::POSTNORD => 'PostNord',
                self::DAO => 'DAO',
            };
        }

        /**
         * Returns the filename of the carrier logo.
         *
         * The Blade view uses this value to load the corresponding image from:
         *   /public/images/carriers/
         *
         * Storing filenames here keeps UI logic centralized and prevents hardcoding
         * in Blade templates or controllers.
         */
        public function logoFile(): string {
            return match ($this) {
                self::GLS => 'gls.png',
                self::DFM => 'dfm.png',
                self::PACKETA => 'packeta.png',
                self::BRING => 'bring.png',
                self::POSTNORD => 'pdk.png',
                self::DAO => 'dao.png',
            };
        }
}
