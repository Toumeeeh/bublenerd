<?php

namespace App\Exceptions;

use Exception;

class CourseUpdateException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Failed to update course", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
