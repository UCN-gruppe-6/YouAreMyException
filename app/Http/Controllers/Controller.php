<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base controller for the application.
 *
 * All HTTP controllers should extend this class. It pulls in
 * common Laravel traits for authorization and validation.
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
