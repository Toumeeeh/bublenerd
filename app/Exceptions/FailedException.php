<?php

namespace App\Exceptions;
use Exception;
class FailedException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "something went wrong", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
