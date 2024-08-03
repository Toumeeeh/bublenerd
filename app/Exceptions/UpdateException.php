<?php

namespace App\Exceptions;

use Exception;

class UpdateException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Failed to update ", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
