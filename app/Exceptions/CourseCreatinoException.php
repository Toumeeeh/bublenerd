<?php

namespace App\Exceptions;

use Exception;

class CourseCreatinoException extends Exception
{
    protected $message;
    protected $code;

    public function __construct($message = "Failed to create course", $code = 400)
    {
        parent::__construct($message, $code);
    }
}
