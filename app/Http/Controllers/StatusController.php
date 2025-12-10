<?php

/**
 * This controller gets the information from the database
 * and gives the view a red/green status.
 */

namespace App\Http\Controllers;

use App\Enums\Carrier;
use App\Models\CarrierError;
use Illuminate\View\View;

/**
 * StatusController
 * - Reads carrier errors from the existing database
 * - Filters for non-deleted errors (soft delete))
 * - Builds a simple status list per carrier for the Blade view
*/
class StatusController extends Controller
{
    /**
     * Shows the drift status page
    */
    public function index(): View
    {
        /**
         * 1) All carriers we want to show in the frontend (fixed list)
         */
        $carriers = Carrier::cases();

        /**
         * 2) Fetch all relevant errors from the existing database:
         * - only enum carriers
         * - only not soft-deleted
        */
        $errors = CarrierError::query()
            ->forCarriers($carrierEnums)
            ->notDeleted()
            ->get()
            ->groupBy(function (CarrierError $error) {
                // If casted as an enum
                if ($error->carrier instanceof Carrier) {
                    return $error->carrier->value;
                }

                // If there only is a string in the database
                return $error->carrier;
            });

        /**
         * Map everything to a simple structure: one entry per carrier
         * Builds the structure that blade expects
        */
        $carriers = collect($carrierEnums)->map(function (Carrier $carrier) use ($errors) {
            $carrierErrors = $errors->get($carrier->value, collect());

            $hasIssue = $carrierErrors->isNotEmpty();

            // If there's more than one error, we make it into one text
            $message = $hasIssue
                ? $carrierErrors->pluck('message')->implode(' • ')
                : 'Ingen kendte problemer';

            return [
                'name'      => $carrier->label(),
                'logo'      => $carrier->logoFile(),
                'has_issue' => $hasIssue,
                'message'   => $message,
            ];
        });

        /**
         * 4) Pass to blade view
        */
        return view('status.index', [
            'carriers' => $carriers,
        ]);
    }
}
