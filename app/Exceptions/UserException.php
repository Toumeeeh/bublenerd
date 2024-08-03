<?php

namespace App\Exceptions;

use Exception;

class UserException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message, $code = 400)
    {
        parent::__construct($message, $code);
    }
}
