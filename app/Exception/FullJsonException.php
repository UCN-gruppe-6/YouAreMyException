<?php

/**
 * FullJsonException
 *
 * We made this class because the errors we get are NOT simple text messages.
 *
 * The company we integrate with sends errors as JSON with a lot of information
 * (message, code, context, metadata, etc.).
 *
 * If we used a normal Exception, we would have to squash all that information
 * down into a single string, and most of the error details would be lost.
 *
 * This class lets us throw an exception while keeping the full JSON error data
 * attached to it.
 *
 * So instead of throwing:
 *     throw new Exception("Something went wrong");
 *
 * we can throw:
 *     throw new FullJsonException($errorDataFromCompany);
 *
 * That way:
 * - Laravel still treats it like a normal exception
 * - the exception handler still catches it
 * - but we still have access to the full original error data later
 *
 * This class does NOT create errors and does NOT handle them.
 * It only carries the error data through the system.
 */

namespace App\Exceptions; // Laravel convention

use Exception; // import the base Exception class

class FullJsonException extends Exception
{
    /**
     * Stores the complete error payload exactly as it was received from the external system.
     */
    public array $data;

    /**
     * Create the exception from JSON/array error data.
     * We pass in the error exactly as we receive it. Nothing is modified or removed.
     */
    public function __construct(array $data)
    {
        // Save the full error data on the exception object.
        $this->data = $data;

        // Laravel still expects a message and a code, so we pull those out of the array.
        // If they are missing, we fall back to safe defaults.
        parent::__construct($data['message'] ?? 'Unknown exception', $data['code'] ?? 500);
    }
}
