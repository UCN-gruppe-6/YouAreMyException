<?php

namespace App\Exception; // Laravel convention

use Exception; // import the base Exception class

class FullJsonException extends Exception
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;

        // Call parent constructor to set the message and code//['message']?? 'Unknown exception'
        parent::__construct(json_encode($data,JSON_PRETTY_PRINT) , $data['code'] ?? 500 );
    }
}
