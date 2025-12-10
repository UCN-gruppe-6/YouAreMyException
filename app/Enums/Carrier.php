<?php

namespace App\Enums;

/**
 * Enum for all supported carriers in the status view.
 * Used to ensure we only show a fixed,
 * known list in frontend.
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
         * Human-readable label so the name gets nicer
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
