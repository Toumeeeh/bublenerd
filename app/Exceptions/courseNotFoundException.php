<?php
namespace App\Exceptions;

    use Exception;

class courseNotFoundException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "course not found", $code = 404)
    {
        parent::__construct($message, $code);
    }
}


