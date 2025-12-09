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
 * - Filters for not deleted
 * - Builds a simple status list per carrier for the Blade view
*/
class StatusController extends Controller
{



}
