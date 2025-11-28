<?php

namespace App\Exceptions; // Laravel convention

use Exception; // import the base Exception class

class FullJsonException extends Exception
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        // Call parent constructor to set the message and code
        parent::__construct($data['message'] ?? 'Unknown exception', $data['code'] ?? 500);
    }
}
