<?php

/**
 * StatusController
 *
 * This controller is responsible for collecting carrier error information
 * from the existing database and preparing a clean, frontend-friendly data
 * structure for the Blade view.
 *
 * Responsibilities:
 * - Load all supported carriers (via enum)
 * - Fetch errors from the database, filtered by carrier and soft delete state
 * - Group and format errors per carrier
 * - Determine whether each carrier is “green” (no issues) or “red” (issues)
 * - Pass a fully prepared array to the UI
 *
 * The controller does not modify the database — it only reads from it.
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
     * index()
     *
     * Displays the drift status page.
     * The returned view receives one structured list containing:
     * - carrier name
     * - logo filename
     * - boolean status ("has_issue")
     * - message to display below the carrier row
     */
    public function index(): View
    {
        /**
         * 1) Load all supported carriers from the Carrier enum.
         *    These represent the transport partners we always show in the UI,
         *    even if they have no errors in the database.
         *    Example: [Carrier::GLS, Carrier::DFM, ...]
         */
        $carrierEnums = Carrier::cases();

        /**
         * 2) Fetch relevant errors from the database:
         *    - Only include rows where `carrier` matches one of our enums
         *    - Only include errors that are NOT soft-deleted (is_deleted = 0)
         */
        $errors = CarrierError::query()
            ->forCarriers($carrierEnums) // Filter by allowed carriers
            ->notDeleted() // Only active (visible) errors
            ->get()
            ->groupBy(function (CarrierError $error) {
                // If Laravel casts "carrier" into an enum, extract its value:
                if ($error->carrier instanceof Carrier) {
                    return $error->carrier->value;
                }

                // Fallback: treat it as a raw string from the database
                return $error->carrier;
            });

        /**
         * 3) Build the structure the Blade view expects.
         *
         * For each carrier:
         * - Lookup errors in the grouped collection
         * - Decide if the carrier has issues (true/false)
         * - Build a combined message string (or fallback message)
         * - Return a simple associative array:
         *   [
         *      'name'      => 'GLS',
         *      'logo'      => 'gls.png',
         *      'has_issue' => true,
         *      'message'   => 'Label-generering fejler • Timeouts mod API'
         *   ]
         */
        $carriers = collect($carrierEnums)->map(function (Carrier $carrier) use ($errors) {
            $carrierErrors = $errors->get($carrier->value, collect());

            // Red/green indicator for UI
            $hasIssue = $carrierErrors->isNotEmpty();

            // Human-readable message for the UI
            $message = $hasIssue
                ? $carrierErrors->pluck('message')->implode(' • ')
                : 'Ingen kendte problemer';

            // Data object returned for the frontend
            return [
                'name'      => $carrier->label(),
                'logo'      => $carrier->logoFile(),
                'has_issue' => $hasIssue,
                'message'   => $message,
            ];
        });

        /**
         * 4) Return the prepared carrier list to the Blade view.
         *
         * The Blade template only receives clean, UI-ready data
         * - no database or business logic needs to exist inside the view.
         */
        return view('status.index', [
            'carriers' => $carriers,
        ]);
    }
}
