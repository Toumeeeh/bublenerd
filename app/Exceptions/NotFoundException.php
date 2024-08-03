<?php

namespace App\Exceptions;


use Exception;

class NotFoundException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = " Not Found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}
